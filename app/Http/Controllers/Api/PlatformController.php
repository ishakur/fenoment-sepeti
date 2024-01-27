<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DeleteFailed;
use App\Exceptions\NotFound;
use App\Exceptions\StoreFailed;
use App\Exceptions\UpdateFailed;
use App\Http\Requests\StorePlatformRequest;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Exception as ExceptionAlias;
use Illuminate\Support\Str;
use Mockery\Matcher\Not;

class PlatformController extends ApiController
{
    public function __construct()
    {
        $this->middleware('isPlatformExist')->only('store', 'update');
        $this->middleware('isAdmin')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $platforms = Platform::paginate(10);

        if ($platforms->count() > 0)
            return $this->apiResponse(PlatformResource::collection($platforms),
                                      $this->getTextFromControllerLanguageFile('showSuccess', 'platforms'),
                                      200);
        else
            throw new NotFound('platforms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePlatformRequest $request
     *
     * @return
     */
    public function store(StorePlatformRequest $request)
    {
        $platform                = new Platform();
        $platform->platform_name = $request->platform_name;
        $platform->slug          = Str::slug($request->platform_name);
        $platform->platform_rank = $request->platform_rank;
        $platform->platform_icon = $request->platform_icon;
        $isSuccess               = $platform->save();

        if (!$isSuccess)
            throw new StoreFailed('platform');

        $platform = new PlatformResource(Platform::findOrFail($platform->id));

        return $this->apiResponse($platform, $this->getTextFromControllerLanguageFile('storeSuccess', 'platform'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     */
    public function show(int $id)
    {
        $platform = Platform::findOrFail($id);

        if ($platform)
            return $this->apiResponse($platform, $this->getTextFromControllerLanguageFile('showSuccess', 'platform'), 200);
        else
            throw new NotFound('platform');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePlatformRequest $request
     * @param Platform             $platform
     *
     */
    public function update(StorePlatformRequest $request, Platform $platform)
    {
        $platform->platform_name = $request->platform_name;
        $platform->slug          = Str::slug($request->platform_name);
        $platform->platform_rank = $request->platform_rank;
        $platform->platform_icon = $request->platform_icon;
        $isSuccess               = $platform->save();

        if (!$isSuccess)
            throw new UpdateFailed('platform');

        $platform = new PlatformResource($platform);

        return $this->apiResponse($platform, $this->getTextFromControllerLanguageFile('updateSuccess', 'platform'), 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Platform $platform
     *
     */
    public function destroy(Platform $platform)
    {
        $isSuccess = $platform->delete();

        if (!$isSuccess)
            throw new DeleteFailed('platform');

        return $this->apiResponse(null, $this->getTextFromControllerLanguageFile('deleteFailed', 'platform'), 200);
    }
}
