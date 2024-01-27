<?php

namespace App\Http\Requests\CorpAdvertiser;

use Illuminate\Foundation\Http\FormRequest;

class StoreCorpAdvertiserRequest extends FormRequest
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
            'corpAdvName'    => 'required|string|max:255|unique:corporate_advertisers',
            'corpAdvAddress' => 'required|string|max:255',
            'taxNumber'      => 'required_if:userType,==,Agency|required_if:userType,==,CorpAdvertiser|numeric|digits_between:10,11',
        ];
    }
}
