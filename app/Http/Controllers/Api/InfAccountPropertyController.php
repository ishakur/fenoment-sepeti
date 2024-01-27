<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\StoreFailed;
use App\Http\Controllers\Controller;
use App\Http\Resources\InfAccountPropertyResource;
use App\Models\InfAccountProperties;
use App\Models\Influencer;
use App\Models\Platform;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\App;

class InfAccountPropertyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param String $platformUserName
     * @param array  $props
     *
     */
    public function store(string $platformUserName, array $props)
    {
        $influencer = Influencer::where('platformUserName', $platformUserName)->first();

        if ($props) {

            $infAccountProperty                       = new InfAccountProperties();
            $infAccountProperty->platformID           = Platform::where('platform_name', 'Instagram')->first()->id;
            $infAccountProperty->platformUserName     = $platformUserName;
            $infAccountProperty->followerCount        = $props['followerCount'];
            $infAccountProperty->followingCount       = $props['followingCount'];
            $infAccountProperty->mediaCount           = $props['mediaCount'];
            $infAccountProperty->avarageLikeCount     = $props['avarageLikeCount'];
            $infAccountProperty->avarageViewCount     = $props['avarageViewCountReels'];
            $infAccountProperty->storyViewCount       = null;
            $infAccountProperty->reachedAccountCount  = null;
            $infAccountProperty->enagagedAccountCount = null;
            $infAccountProperty->saveCount            = null;
            $infAccountProperty->shareCount           = null;
            $infAccountProperty->socialVerify         = $props['isVerified'];
            $infAccountProperty->infID                = $influencer->infID;

            $isSuccess = $infAccountProperty->save();

            if (!$isSuccess)
                throw new StoreFailed($this->getTextFromKeywordsLanguageFileNonAttribute('influencerAccountProperty'));


            return $this->apiResponse($infAccountProperty,
                                      $this->getTextFromControllerLanguageFile('storeSuccess', 'influencerAccountProperty'),
                                      201);
        } else
            throw new StoreFailed($this->getTextFromKeywordsLanguageFileNonAttribute('influencerAccountProperty'));

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     */
    public function show(int $id)
    {
        $infAccountProperty         = InfAccountProperties::find($id);
        $infAccountPropertyResource = new InfAccountPropertyResource($infAccountProperty);
        $this->apiResponse($infAccountPropertyResource,
                           $this->getTextFromControllerLanguageFile('showSuccess', 'influencerAccountProperty'),
                           200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request         $request
     * @param \App\Models\InfAccountProperties $infAccountProperty
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfAccountProperties $infAccountProperty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\InfAccountProperties $infAccountProperty
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfAccountProperties $infAccountProperty)
    {
        //
    }
}
