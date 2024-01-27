<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\ProductProperties;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
//        return $this->influencer;
        return [
            'product_id'               => $this->id,
            'influencer'               => $this->when(Str::contains($request->url(), 'api/products'), new InfluencerResource($this->influencer)),
            'property'                 => new ProductPropertyResource($this->property),
            'price_for_per_minute'     => $this->price_for_per_minute,
            'fenocityProductSaleCount' => $this->fenocityProductSaleCount,
            'fenocityProductPoint'     => $this->fenocityProductPoint,
        ];
    }
}
