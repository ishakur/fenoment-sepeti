<?php

namespace App\Http\Controllers\Api;

use App\Enum\OrderStatus;

use App\Exceptions\Empty_;
use App\Exceptions\NotFound;
use App\Exceptions\StoreFailed;
use App\Exceptions\UpdateFailed;
use App\Http\Requests\Order\StoreOrderItemRequest;
use App\Http\Requests\Order\UpdateOrderItem;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\ProductResource;
use App\Models\OrderDetails;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception as ExceptionAlias;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Mockery\Matcher\Not;

class OrderItemController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     */

    public function index(Request $request)
    {
        //suanki sepetin urunlerini getir geri donen obje OrderDetaildir yani Sepet Modeli
        $currentBasket = $request->currentBasketFromMiddleWare;

        //aktif sepetin urunlerini getiriyor -> OrderItem Model geri donuyor
        $currentBasketItems = $currentBasket->orderItem;
//        return $currentBasketItems;
        if ($currentBasketItems->isEmpty())
            throw new Empty_('basket');

        return self::apiResponse(OrderItemResource::collection($currentBasketItems),
                                 $this->getTextFromControllerLanguageFile('showSuccess', 'basket'),
                                 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(StoreOrderItemRequest $request)
    {
        $orderItem     = new OrderItems();
        $productId     = $request->productId;
        $adDuration    = $request->adDuration;
        $currentBasket = $request->currentBasketFromMiddleWare;

        if (!$product = Product::find($productId))
            throw new NotFound('product');


        //requestten gelen order id aslinda middleware ile gelen order id
        $orderItem->order_id            = $currentBasket->id;
        $orderItem->product_id          = $productId;
        $orderItem->seller_id           = $product->influencer_id;
        $orderItem->seller_confirmation = false;
        $orderItem->status              = OrderStatus::OnChart;
        $orderItem->ad_duration         = $adDuration;
        $orderItem->ad_total_price      = Product::findOrFail($productId)->price_for_per_minute * $adDuration;
        $orderItemIsFail                = $orderItem->save();


        if (!$orderItemIsFail)
            throw new storeFailed('orderDetail');

        $orderItemResource = new OrderItemResource($orderItem);
        return $this->apiResponse($orderItemResource, $this->getTextFromControllerLanguageFile('orderItemAddedCart'), 201);

    }

    /**
     * Display the specified resource.
     *
     */
    public function show(int $productId)
    {
//        $product = Product::findOrFail($productId);
//        return $product;
//        return $this->apiResponse(new ProductResource($product), 'Product', 200);
//        //
////            $purchaser_id = OrderItems::findOrFail($id)->orderDetail->purchaser_id;
////            if ($purchaser_id == auth()->id()) {
////                $orderItem = new OrderItemResource(OrderItems::findOrFail($id));
////                return $this->apiResponse($orderItem, 'OrderItems', 200);
////            } else {
////                return $this->apiResponse(null, 'You are not authorized to see this orderItem', 403);
////            }
////        } catch (ExceptionAlias $e) {
////            return $this->apiResponse(null, $e->getMessage(), 404);
////        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     */
    public function update(UpdateOrderItem $request, int $orderItemId)
    {
        //suanki sepetin urunlerini getir geri donen obje OrderDetaildir yani Sepet Modeli
        $currentBasket = $request->currentBasketFromMiddleWare;

        //aktif sepetin urunlerini getiriyor -> OrderItem Model geri donuyor
        $currentBasketItems = $currentBasket->orderItem;

        //kendi urunlerimizin idsini requestten gelen yani silmek istedigimiz urun idsi ile karsilastiriyoruz
        // eger ayniysa silme islemi yapiliyor yoksa 404 donuyor
        $orderItem = $currentBasketItems->filter(function ($item) use ($orderItemId) {
            return $item->id == $orderItemId;
        })->first();

        //TODO burada requestten gelen orderItemId sadece user kendininkini duzenlesin
        if (!$orderItem)
            throw new NotFound('orderItem');

        $orderItem->ad_duration = $request->adDuration ?? $orderItem->adDuration;
        $product                = Product::find($orderItem->product_id);
        if (!$product)
            throw new \Exception($this->getTextFromControllerLanguageFile('notFound', 'product'), 500);

        $orderItem->ad_total_price      = $product->price_for_per_minute * $request->ad_duration;
        $orderItemUpdateSuccessOrFailed = $orderItem->update((array)$orderItem);

        if (!$orderItemUpdateSuccessOrFailed)
            throw new UpdateFailed('orderDetail');

        return $this->apiResponse(new OrderItemResource($orderItem), $this->getTextFromControllerLanguageFile('orderItemUpdatedCart'), 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $orderItemId
     */
    public function destroy(Request $request, int $orderItemId)
    {
        //suanki sepetin urunlerini getir geri donen obje OrderDetaildir yani Sepet Modeli
        $currentBasket = $request->currentBasketFromMiddleWare;

        //aktif sepetin urunlerini getiriyor -> OrderItem Model geri donuyor
        $currentBasketItems = $currentBasket->orderItem;

        //kendi urunlerimizin idsini requestten gelen yani silmek istedigimiz urun idsi ile karsilastiriyoruz
        // eger ayniysa silme islemi yapiliyor yoksa 404 donuyor
        $orderItem = $currentBasketItems->filter(function ($item) use ($orderItemId) {
            return $item->id == $orderItemId;
        })->first();

        if (!$orderItem)
            throw new NotFound('orderItem');


        $orderDeleteSuccessOrFailed = $orderItem->delete();

        if (!$orderDeleteSuccessOrFailed)
            throw new UpdateFailed('orderDetail');

//        if ($orderItem->status == OrderStatus::OnChart) {
//            return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('orderItemRemovedCart'), 200);
//        }

//        if ($orderItem->status == OrderStatus::OrderCanceled) {
//            $orderItem->status = OrderStatus::OrderCanceled;
//            $orderItem->update((array)$orderItem);
//            return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('cancelled', 'orderItem'), 200);
//        }

        return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('deleteSuccess', 'orderItem'), 200);
    }

    public function unloadBasket(Request $request)
    {
        $currentBasket = $request->currentBasketFromMiddleWare;
        $count         = $currentBasket->destroyBasketItems();
        if ($count == 0)
            throw new NotFound('orderItem');

        return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('orderDetailsItemDestroy'), 200);

    }
}
