<?php

namespace App\Http\Requests\Agency;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgencyRequest extends FormRequest
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
            'agencyName' => 'required_if:userType,==,Agency|string|max:255|min:3|unique:agencies',
            //            'agencyAddress'    => 'required_if:userType,==,Agency|string|max:255|min:7',
            //            'taxNumber'        => 'required_if:userType,==,Agency|required_if:userType,==,CorpAdvertiser|numeric|digits_between:10,11',
        ];
    }
}
