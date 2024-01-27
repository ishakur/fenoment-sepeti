<?php

namespace App\Http\Requests\Influencer;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfluencerRequest extends FormRequest
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
    public function rules(): array
    {
        return [
//            'agencyID'         => 'integer|nullable|exists:agencies,agencyID',
'platformUserName' => 'required|string|max:255|unique:influencers',
//            'bannerPhoto'      => 'nullable|string|max:255',
//            'taxPayer'         => 'required|boolean',
//            'categories'       => 'required|array|min:1|exists:categories,id',
        ];
    }
}
