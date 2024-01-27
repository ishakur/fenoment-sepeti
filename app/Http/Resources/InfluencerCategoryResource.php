<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
//        $influencer = Influencer::findOrFail($this->influencer_id);
//        $category = Category::with($this->category_id);


        return Category::whereId($this->category_id);
//        return [
//            'influencer_id'          => new InfluencerResource($influencer),
//        'category_id' => new CategoryResource($category),
//        ];
    }
}
