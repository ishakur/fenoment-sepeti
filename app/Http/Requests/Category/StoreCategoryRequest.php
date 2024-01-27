<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'category_name'   => 'required|string|max:255',
            'category_up'     => 'required|int',
            'category_rank'   => 'required|int',
            'category_icon'   => 'string|max:255|nullable',
            'category_status' => 'required|boolean',
        ];
    }
}
