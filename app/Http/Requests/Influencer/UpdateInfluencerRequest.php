<?php

namespace App\Http\Requests\Influencer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfluencerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
//      dd($this->request->get('infID'));
        return [
            'agencyID'          => 'integer|nullable|exists:agencies,agencyID',
            'platformUserName'  => 'string|max:255|unique:influencers',
            'bannerPhoto'       => 'nullable|string|max:255',
            'fenocityPoint'     => 'regex:/^\d*(\.\d{1,2})?$/',
            'fenocitySaleCount' => 'integer',
            'infVerify'         => 'boolean',
            'statsVerify'       => 'boolean',
            'taxPayer'          => 'boolean',
            'categories'        => 'array|min:1|exists:categories,id',
        ];
    }
}
