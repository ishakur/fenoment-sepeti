<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPropertyResource extends JsonResource
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
            'property_id'   => $this->resource->id,
            'property_name' => $this->resource->property_name,
            'platform'      => new PlatformResource($this->resource->platform),
        ];
    }
}
