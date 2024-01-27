<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->userTypeValidator();
        Schema::defaultStringLength(191);
    }

    function userTypeValidator()
    {
        Validator::extend('userTypeBeUserOrInfluencerOrAgencyOrCorpAdvertiser', function ($attribute, $value, $parameters, $validator) {
            $inputs   = $validator->getData();
            $userType = $inputs['userType'];
            if ($userType == 'Influencer' || $userType == "User" || $userType == 'Agency' || $userType == 'CorpAdvertiser') {
                return true;
            } else {
                return false;
            }

        });
    }
}
