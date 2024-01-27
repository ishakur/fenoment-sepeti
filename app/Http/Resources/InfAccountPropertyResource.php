<?php

namespace App\Http\Resources;

use App\Models\Influencer;
use App\Models\Platform;
use Illuminate\Http\Request as RequestAlias;
use Illuminate\Http\Resources\Json\JsonResource;

class InfAccountPropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param RequestAlias $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            //            'infAccPropID'         => $this->resource->infAccPropID,
            //            'influencer'           => new InfluencerResource($this->whenLoaded('influencer')),
            //            'platform'             =>  $this->resource,
            'platform'         => new PlatformResource($this->resource->platform),
            'followerCount'    => $this->resource->followerCount,
            //            'followingCountresource->'       => $this->followingCount,
            'mediaCount'       => $this->resource->mediaCount,
            'avarageLikeCount' => $this->resource->avarageLikeCount,
            'avarageViewCount' => $this->resource->avarageViewCount,
            'storyViewCount'   => $this->resource->storyViewCount,
            //            'reachedAccountCount'  => $this->reachedAccountCount,
            //            'enagagedAccountCount' => $this->enagagedAccountCount,
            //            'saveCount'            => $this->saveCount,
            //            'shareCount'           => $this->shareCount,
        ];
    }
}
