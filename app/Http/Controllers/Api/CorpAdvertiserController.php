<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\StoreFailed;
use App\Http\Controllers\Controller;
use App\Http\Requests\CorpAdvertiser\StoreCorpAdvertiserRequest;
use App\Models\Corpadvertiser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Spatie\FlareClient\Api;

class CorpAdvertiserController extends ApiController
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
     * @param StoreCorpAdvertiserRequest $request
     * @param User                       $user
     *
     */
    public function store(StoreCorpAdvertiserRequest $request, User $user)
    {
        $corpAdvertiser                 = Corpadvertiser::firstOrNew($user->userID);
        $corpAdvertiser->corpAdvName    = $request->corpAdvName;
        $corpAdvertiser->corpAdvAddress = $request->corpAdvAddress;
        $corpAdvertiser->taxNumber      = $request->taxNumber;
        $corpAdvertiser->userID         = $user->userID;
        $isSuccess                      = $corpAdvertiser->save();

        if (!$isSuccess) {
            User::where('userID', $user->userID)->delete();
            throw new StoreFailed($this->getTextFromKeywordsLanguageFileNonAttribute('corpAdvertiser'));
        }

        return $corpAdvertiser;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Corpadvertiser $corpAdvertiser
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Corpadvertiser $corpAdvertiser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \App\Models\Corpadvertiser $corpAdvertiser
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Corpadvertiser $corpAdvertiser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Corpadvertiser $corpAdvertiser
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corpadvertiser $corpAdvertiser)
    {
        //
    }
}
