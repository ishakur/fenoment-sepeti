<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class PlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'platform_id'   => $this->id,
            'platform_name' => $this->platform_name,
            'platform_rank' => $this->platform_rank,
            'platform_icon' => $this->platform_icon,
            'influencers'   => InfluencerResource::collection($this->whenLoaded($this->influencers)),
        ];
    }
}
