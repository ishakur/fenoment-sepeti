<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DeleteFailed;
use App\Exceptions\NotFound;
use App\Exceptions\UpdateFailed;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Support\Str;
use OpenApi\Attributes\Delete;

class CategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware(['isCategoryExist', 'isAdmin'])->only('store', 'update', 'destroy');
    }


    public function index()
    {
        $data = Category::getCategories();

        if ($data == null)
            throw new NotFound(self::getTextFromKeywordsLanguageFile('category'));

        return $this->apiResponse($data, $this->getTextFromControllerLanguageFile('showSuccess', 'categories'), 201);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     *
     */
    public function store(StoreCategoryRequest $request)
    {
        $createCategory = Category::createCategory($request);

        if (!$createCategory)
            throw new NotFound(self::getTextFromKeywordsLanguageFile('category'));

        return $this->apiResponse($createCategory, $this->getTextFromControllerLanguageFile('storeSuccess', 'category'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int    $id
     * @param string $with
     */
    public function show(int $id, string $with = null)
    {
        $category = match ($with) {
            'influencers' => Category::with('influencers')->findOrFail($id),
            'products'    => Category::with('products')->findOrFail($id),
            default       => Category::findOrFail($id),
        };

        if ($category)
            return $this->apiResponse(new CategoryResource($category), $this->getTextFromControllerLanguageFile('showSuccess', 'category'), 200);
        else
            throw new NotFound(self::getTextFromKeywordsLanguageFile('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param Category             $category
     *
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->category_name   = $request->category_name ?? $category->category_name;
        $category->slug            = Str::slug($request->category_name) ?? $category->slug;
        $category->category_up     = $request->category_up ?? $category->category_up;
        $category->category_rank   = $request->category_rank ?? $category->category_rank;
        $category->category_icon   = $request->category_icon ?? $category->category_icon;
        $category->category_status = $request->category_status ?? $category->category_status;
        $isSucces                  = $category->save();

        if (!$isSucces)
            throw new UpdateFailed(self::getTextFromKeywordsLanguageFile('category'));

        return $this->apiResponse($category, $this->getTextFromControllerLanguageFile('updateSuccess', 'category'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     *
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $isSuccess = $category->delete();

        if (!$isSuccess)
            throw new DeleteFailed(self::getTextFromKeywordsLanguageFile('category'));

        return $this->apiResponse($isSuccess, $this->getTextFromControllerLanguageFile('deleteSuccess', 'category'), 200);
    }
}
