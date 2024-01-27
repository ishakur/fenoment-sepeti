<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DeleteFailed;
use App\Exceptions\NotFound;
use App\Exceptions\StoreFailed;
use App\Exceptions\UpdateFailed;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Influencer;
use App\Models\Product;

class ProductController extends ApiController
{
    public function __construct()
    {
        $this->middleware('isProductExist')->only('store', 'update');
//            $this->middleware('verified');
    }


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $products = Product::with('influencer')->get()->take(10);
//            return Product::with('influencer')->get()->take(1);
        if ($products->count() > 0)
            return $this->apiResponse(ProductResource::collection($products),
                                      $this->getTextFromControllerLanguageFile('showSuccess', 'products'),
                                      200);
        else
            throw new NotFound('products');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     */
    public function store(StoreProductRequest $request)
    {

        //TODO eger daha once ayni platform kullandiysa onu getir tum controllerlarda bunu middleware olarak kullan
        $influencer_id = Influencer::where('userID', auth()->id())->first()->infID;

        if ($influencer_id == null)
            throw new NotFound('influencer');

        $isSuccess = Product::createProduct($request, $influencer_id);
        $product   = Product::getById($isSuccess);

        if (!$isSuccess)
            throw new StoreFailed('product');

//            $product = new ProductResource(Product::findOrFail($isSuccess->id));

        return $this->apiResponse($product, $this->getTextFromControllerLanguageFile('storeSuccess', 'product'), 201);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $product = Product::find($id);

        if (!$product)
            throw new NotFound('product');

        return $this->apiResponse(new ProductResource($product), $this->getTextFromControllerLanguageFile('showSuccess', 'product'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreProductRequest $request
     * @param Product             $product
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $product->influencer_id        = $request->influencer_id;
        $product->product_property_id  = $request->product_property_id;
        $product->price_for_per_minute = $request->price_for_per_minute;
        $isSuccess                     = $product->save();

        if (!$isSuccess)
            throw new UpdateFailed('product');

        $product = new ProductResource($product);

        return $this->apiResponse($product, $this->getTextFromControllerLanguageFile('updateSuccess', 'product'), 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     */
    public function destroy(Product $product)
    {
        $isSuccess = $product->delete();

        if (!$isSuccess)
            throw new DeleteFailed('product');

        return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('deleteSuccess', 'product '), 200);

    }
}

