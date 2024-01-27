<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            //TODO google id ile register olunca password olmamali
            'userType'     => 'required|string|userTypeBeUserOrInfluencerOrAgencyOrCorpAdvertiser',
            'nameSurname'  => 'required|string|max:255',
            'email'        => 'required|email|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/',
            'password'     => 'required_without:googleId|min:8|max:20|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'profilePhoto' => 'nullable|string',
            'googleId'     => 'required_without:password|string|unique:user_verifications',

            //            'password_confirmation' => 'required|min:8|string|max:20|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            //            'phoneNumber'           => 'nullable|string|min:10|max:11|unique:user_verifications',
            //            'agencyID'              => 'integer|exists:agencies,agencyID|nullable',
            //            'categories'            => 'required_if:userType,==,Influencer|array|min:1',
            //            'categories.*'          => 'integer|exists:categories,id',
            //            'platformUserName'      => 'required_if:userType,==,Influencer|string',
            //            'bannerPhoto'           => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            //            "taxPayer"              => 'required_if:userType,==,Influencer|boolean',
            //            'corpAdvName'           => 'required_if:userType,==,CorpAdvertiser|string|max:255',
            //            'corpAdvAddress'        => 'required_if:userType,==,CorpAdvertiser|string|max:255',
            //            'agencyName'            => 'required_if:userType,==,Agency|string|max:255|min:3',
            //            'agencyAddress'         => 'required_if:userType,==,Agency|string|max:255|min:7',
            //            'taxNumber'             => 'required_if:userType,==,Agency|required_if:userType,==,CorpAdvertiser|string|min:10|max:11|unique:agencies|unique:corporate_advertisers',
        ];
    }
}
