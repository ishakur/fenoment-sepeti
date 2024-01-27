<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFound;
use App\Exceptions\StoreFailed;
use App\Exceptions\UpdateFailed;
use App\Http\Resources\ProductPropertyResource;
use App\Models\ProductProperties;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;

class ProductPropertyController extends ApiController
{
    public function __construct()
    {
        $this->middleware('isProductPropertyExist')->only('store', 'update');
        $this->middleware('isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $productProperty = ProductProperties::paginate(10);

        if ($productProperty->count() <= 0)
            throw new NotFound('productProperty');

        return $this->apiResponse(ProductPropertyResource::collection($productProperty),
                                  $this->getTextFromControllerLanguageFile('showSuccess', 'productProperties'),
                                  200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $productProperty                = new ProductProperties();
        $productProperty->property_name = $request->property_name;
        $productProperty->platform_id   = $request->platform_id;
        $isSuccess                      = $productProperty->save();

        if (!$isSuccess)
            throw new StoreFailed('productProperty');

        $productProperty = new ProductPropertyResource($productProperty);

        return $this->apiResponse($productProperty, $this->getTextFromControllerLanguageFile('storeSuccess', 'productProperty'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $productProperty = ProductProperties::find($id);

        if (!$productProperty)
            throw new NotFound('productProperty');
        return $this->apiResponse(new ProductPropertyResource($productProperty),
                                  $this->getTextFromControllerLanguageFile('showSuccess', 'productProperty'),
                                  200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request           $request
     * @param ProductProperties $productProperty
     *
     */
    public function update(Request $request, ProductProperties $productProperty)
    {
        $productProperty->property_name = $request->property_name;
        $productProperty->platform_id   = $request->platform_id;
        $isSuccess                      = $productProperty->save();

        if (!$isSuccess)
            throw new UpdateFailed('productProperty');

        $productProperty = new ProductPropertyResource($productProperty);

        return $this->apiResponse($productProperty, $this->getTextFromControllerLanguageFile('updateSuccess', 'productProperty'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductProperties $productProperty
     *
     */
    public function destroy(ProductProperties $productProperty)
    {
        $isSuccess = $productProperty->delete();

        if (!$isSuccess)
            throw new NotFound('productProperty');

        return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('deleteFailed', 'productProperty'), 200);

    }
}
