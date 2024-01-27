<?php

    namespace App\Http\Controllers\Api;


    use App\Exceptions\StoreFailed;
    use App\Http\Requests\Agency\StoreAgencyRequest;
    use App\Models\Agency;
    use App\Models\User;
    use Exception;
    use Illuminate\Http\Request;


    class AgencyController extends ApiController
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
         * @param StoreAgencyRequest $request
         * @param User               $user
         *
         */

        public function store(StoreAgencyRequest $request, User $user)
        {


            $agency                = new Agency();
            $agency->agencyName    = $request->agencyName;
            $agency->agencyAddress = $request->agencyAddress;
            $agency->taxNumber     = $request->taxNumber;
            $agency->userID        = $user->userID;
            $isSuccess             = $agency->save();

            if (!$isSuccess) {
                User::find('userID', $user->userID)->delete();
                throw new StoreFailed($this->getTextFromKeywordsLanguageFileNonAttribute('agency'));
            } else
                return $agency;


        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\agency $agency
         *
         * @return \Illuminate\Http\Response
         */
        public
        function show(agency $agency)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\agency $agency
         *
         * @return \Illuminate\Http\Response
         */
        public
        function edit(agency $agency)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Models\agency       $agency
         *
         * @return \Illuminate\Http\Response
         */
        public
        function update(Request $request, agency $agency)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\agency $agency
         *
         * @return \Illuminate\Http\Response
         */
        public
        function destroy(agency $agency)
        {
            //
        }
    }
