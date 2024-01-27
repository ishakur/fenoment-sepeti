<?php

namespace App\Http\Controllers\Api;

use App\Enum\OrderStatus;
use App\Http\Requests\AllBasketRequest;
use App\Http\Requests\Order\StoreOrderDetailRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderDetailController extends ApiController
{
    public function __construct()
    {

        $this->middleware('isOrderDetailActiveForOrderItem')->only(['index', 'show']);
//        $this->middleware('IsCartOrderExist')->except('update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {

        $orderDetails = $request->user->getMyOrders;
        return $this->apiResponse(OrderDetailResource::collection($orderDetails),
                                  $this->getTextFromControllerLanguageFile('showSuccess', 'orderDetails'),
                                  200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderDetailRequest $request
     */
    public function store(StoreOrderDetailRequest $request)
    {
        $orderDetail               = new OrderDetails();
        $orderDetail->purchaser_id = OrderDetails::findOrCreate($request->order_id);
        $orderDetail->status       = OrderStatus::ActiveOrder;

        //paymetn_id
        $orderDetail->save();

        $orderDetail->total_price = $orderDetail->getTotalPrice();
        $orderDetail->update((array)$orderDetail);

        $orderDetail = new OrderItemResource(Product::findOrFail($request->product_id));

        return $this->apiResponse($orderDetail, 'Order created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Request $request, $order_id)
    {

        $orderDetail = $request->user->getMyOrderById->find($order_id);
        return $this->apiResponse(new OrderDetailResource($orderDetail),
                                  $this->getTextFromControllerLanguageFile('showSuccess', 'orderDetail'),
                                  200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        //bug var burda. 2.kez silme islemi yapildiginda yeni sepet olusturuyor

        $orderDetail = OrderDetails::findOrFail($id);

        if ($orderDetail->status == OrderStatus::ActiveOrder) {
            $orderDetail->status = OrderStatus::OrderCanceled;
            $orderDetail->update((array)$orderDetail);
            return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('cancelled', 'orderDetail'), 200);
        }

        return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('deleteFailed', 'orderDetail'), 404);
    }

}
