<?php

namespace App\Http\Resources;


use App\Models\Category;
use App\Models\InfluencerCategories;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'infID'             => $this->resource->infID,
            'nameSurname'       => $this->resource->user->nameSurname,
            'bannerPhoto'       => $this->resource->bannerPhoto,
            'fenocityPoint'     => $this->resource->fenocityPoint,
            'fenocitySaleCount' => $this->resource->fenocitySaleCount,
            'platformUserName'  => $this->resource->platformUserName,
            'profilePhoto'      => $this->resource->user->profilePhoto,
            //                        'products'           => $this->whenLoaded('products'),
            'categories'        => $this->resource->categories->map(function ($category) {
                return $category->category;
            }),

            'product' => ProductResource::collection($this->when(!empty($request->id), $this->resource->products)),
            //            'infVerify'          => $this->resource,

            'account_properties' => InfAccountPropertyResource::collection($this->when(!empty($this->resource->accountProperties),
                                                                                       $this->resource->accountProperties)),
        ];
    }

}
