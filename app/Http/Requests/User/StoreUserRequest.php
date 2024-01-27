<?php

namespace App\Http\Requests\User;

use App\Enum\UserTypes;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'userType'         => 'required|userTypeBeUserOrInfluencerOrAgencyOrCorpAdvertiser',
            'nameSurname'      => 'required|string|max:255',
            'email'            => 'required|email|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/',
            'password'         => 'min:8|max:20|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'phoneNumber'      => 'nullable|numeric|digits_between:10,11|unique:user_verifications',
            'profilePhoto'     => 'nullable|string',
            'google_id'        => 'nullable|string|unique:user_verifications',
            'platformUserName' => 'string|nullable|unique:influencers',
        ];
    }
}
