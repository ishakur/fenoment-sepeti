<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {

        return [
            'category_id'   => $this->id,
            'category_name' => $this->category_name,
            'category_up'   => $this->category_up,
            'category_rank' => $this->category_rank,
            'category_icon' => $this->category_icon,
            'influencers'   => InfluencerResource::collection($this->whenLoaded('influencers')),
            'products'      => InfluencerResource::collection($this->whenLoaded('products')),
        ];
    }
}
