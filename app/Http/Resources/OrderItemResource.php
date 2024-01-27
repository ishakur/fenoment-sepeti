<?php

namespace App\Http\Resources;

use App\Enum\OrderStatus;
use App\Http\Helpers\BooleanToStringFalseOrTrue;
use App\Models\OrderDetails;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'                  => $this->id,
            'seller'              => $this->influencer,
            'seller_confirmation' => $this->when(!str_contains($this->status, OrderStatus::OnChart), ($this->seller_confirmation)),
            'product'             => new ProductResource($this->product),
            'status'              => $this->status,
            'ad_duration'         => $this->ad_duration,
            'ad_total_price'      => $this->ad_total_price,
        ];
    }
}
