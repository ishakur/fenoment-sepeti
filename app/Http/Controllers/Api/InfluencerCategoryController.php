<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFound;
use App\Exceptions\ShowFailed;
use App\Exceptions\StoreFailed;
use App\Http\Requests\Influencer\StoreInfluencerCategoryRequest;
use App\Http\Resources\InfluencerCategoryResource;
use App\Models\InfluencerCategories;
use Exception;

class InfluencerCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('isInfluencerCategoryExist')->only('store', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $data = InfluencerCategoryResource::collection(InfluencerCategories::paginate(10))->additional([
                                                                                                           'meta' => [
                                                                                                               'status'  => 200,
                                                                                                               'message' => $this->getTextFromControllerLanguageFile('showSuccess',
                                                                                                                                                                     'influencerCategory'),
                                                                                                           ],
                                                                                                       ]);

        if ($data->isEmpty())
            throw new ShowFailed($this->getTextFromKeywordsLanguageFileNonAttribute('influencerCategory'));

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInfluencerCategoryRequest $request
     * @param int                            $infID
     *
     */
    public function store(StoreInfluencerCategoryRequest $request, int $infID)
    {

        foreach ($request->categories as $category) {
            $influencerCategory                = new InfluencerCategories();
            $influencerCategory->influencer_id = $infID;
            $influencerCategory->category_id   = $category;
            $isSuccess                         = $influencerCategory->save();
        }

        if (!$isSuccess) throw new StoreFailed($this->getTextFromKeywordsLanguageFileNonAttribute('influencerCategory'));
        else {
            $influencerCategoryResource = new InfluencerCategoryResource(InfluencerCategories::findOrFail($influencerCategory->influencer_id));
            return $this->apiResponse($influencerCategoryResource,
                                      $this->getTextFromControllerLanguageFile('storeSuccess', 'influnecerCategory'),
                                      201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return
     */
    public function show(int $id)
    {
        $influencerCategory = InfluencerCategories::find($id);

        if (!$influencerCategory)
            throw new NotFound('influencerCategory');

        $influencerCategoryResource = new InfluencerCategoryResource($influencerCategory);
        return $this->apiResponse($influencerCategoryResource, $this->getTextFromControllerLanguageFile('showSuccess', 'influencerCategory'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreInfluencerCategoryRequest $request
     * @param int                            $id
     */
    public function update(StoreInfluencerCategoryRequest $request, int $id)
    {
        $influencerCategory                = InfluencerCategories::find($id);
        $influencerCategory->influencer_id = $request->influencer_id;
        $influencerCategory->category_id   = $request->category_id;
        $influencerCategory                = $influencerCategory->save();

        if (!$influencerCategory)
            throw new NotFound('influencerCategory');

        $influencerCategoryResource = new InfluencerCategoryResource($influencerCategory);

        return $this->apiResponse($influencerCategoryResource, $this->getTextFromControllerLanguageFile('updateSuccess', 'influencerCategory'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $influencerCategory = InfluencerCategories::find($id);

        if (!$influencerCategory)
            throw new NotFound('influencerCategory');

        return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('deleteSuccess', 'influencerCategory'), 200);
    }
}
