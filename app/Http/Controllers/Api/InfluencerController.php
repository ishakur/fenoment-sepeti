<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserTypes;
use App\Exceptions\DeleteFailed;
use App\Exceptions\NotFound;
use App\Exceptions\ShowFailed;
use App\Exceptions\StoreFailed;
use App\Exceptions\UpdateFailed;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Influencer\StoreInfluencerRequest;
use App\Http\Requests\Influencer\UpdateInfluencerRequest;
use App\Http\Resources\InfluencerResource;
use App\Models\Category;
use App\Models\Influencer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class InfluencerController extends ApiController
{

    public function __construct()
    {
//            $this->middleware('update')->only('update');
//            $this->middleware('CheckUserTypeWhenInfluencerDestroy')->only('destroy', 'update');
    }


    public function index(Request $request)
    {
        $influencers = Influencer::getAllInfluencer($request->limit < 20 ? $request->limit : 20);

        if (!$influencers)
            throw new NotFound('influencers');


        $influencers = InfluencerResource::collection($influencers);
        return self::apiResponse($influencers, self::getTextFromControllerLanguageFile('storeSuccess', 'influencers'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInfluencerRequest $request
     * @param User                   $user
     *
     */
    public function store(StoreInfluencerRequest $request, User $user)
    {
        $influencer = Influencer::firstOrNew([
                                                 'userID'            => $user->userID,
                                                 'agencyID'          => $request->agencyID ?? null,
                                                 'platformUserName'  => $request->platformUserName,
                                                 'bannerPhoto'       => $request->bannerPhoto ?? null,
                                                 'bioVerifyCode'     => '$BVC' . Str::random(60),
                                                 'statsVerify'       => false,
                                                 'isInfDeleted'      => false,
                                                 'taxPayer'          => $request->taxPayer == 'true',
                                                 'fenocityPoint'     => 0.00,
                                                 'fenocitySaleCount' => 0,
                                                 'infVerify'         => false,
                                             ]);

        if (!$influencer)
            throw new NotFound('influencer');

        return self::apiResponse($influencer, $this->getTextFromControllerLanguageFile('storeSuccess', 'influencer'), 200);

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return
     */
    public function show(Request $request, int $id)
    {

        $influencer = Influencer::find($id);
        $request->merge(['id' => $id]);
        return $this->apiResponse(new InfluencerResource($influencer->load(['products', 'accountProperties'])),
                                  $this->getTextFromControllerLanguageFile('showSuccess', 'influencer'),
                                  200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInfluencerRequest $request
     *
     */
    public function update(UpdateInfluencerRequest $request)
    {
        $id = auth()->user()->influencer->infID ?? null;

        $influencer = Influencer::updateInfluencer($request, $id);

        if (!$influencer || $influencer == null)
            throw new UpdateFailed('influencer');

        return $this->apiResponse($influencer, $this->getTextFromControllerLanguageFile('updateSuccess', 'influencer'), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     */
    public function destroy(int $id)
    {
        $influencer = Influencer::where('infID', $id)->first();
        $user       = User::where('userID', $influencer->userID)->first();

        $user->userType = UserTypes::Deleted;
        $user           = $user->update((array)$user);

        if (!$user)
            throw new NotFound('influencer');


        $influencer->isInfDeleted = true;
        $influencer               = $influencer->update((array)$influencer);

        if (!$user)
            throw new DeleteFailed('influencer');

        return $this->apiResponse($influencer, $this->getTextFromControllerLanguageFile('deleteSuccess', 'influencer'), 200);
    }
}


//public function getInfluencerByCategory(CategoryRequest $categoryID)
//{
//
//    $influencers = Influencer::getInfluencerByCategory($categoryID->category);
//    if (!$influencers)
//        throw new Exception(__('controller.influencerot_found'), 404);
//
//    return $this->apiResponse($influencers, __('controller.influencer_success'), 200);
//
//}
