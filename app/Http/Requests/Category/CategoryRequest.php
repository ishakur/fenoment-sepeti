<?php

    namespace App\Http\Requests\Category;

    use Illuminate\Foundation\Http\FormRequest;


    class CategoryRequest extends FormRequest
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

            return [
                'category' => 'required|int|exists:categories,id'
                //                'url' => 'required|regex:'.$regex,
            ];
        }

        public function validationData()
        {
            return array_merge($this->request->all(), [
                'category' => $this->route()->parameter('category'),
            ]);
        }


    }
