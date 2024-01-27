<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderDetailRequest extends FormRequest
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
            'purchaser_id'=> 'required',
            'status'=> 'nullable|in:0,1,2',
            'total_price'=> 'nullable|double',//buralar girilmeyeck iceride id ile auto cekeceek
            'payment_id'=> 'nullable|integer',
        ];
    }
}
