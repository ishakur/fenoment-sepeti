<?php

namespace App\Http\Resources;

use App\Enum\OrderStatus;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            //            'purchaser_id' => new UserResource($this->user),
            'id'          => $this->id,
            'status'      => $this->status,
            'total_price' => $this->total_price,
            'payment_id'  => $this->payment_id,
        ];
    }
}
