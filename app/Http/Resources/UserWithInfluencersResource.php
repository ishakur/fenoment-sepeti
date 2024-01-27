<?php

namespace App\Http\Resources;

use App\Models\Influencer;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWithInfluencersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'userID'      => $this->userID,
            'nameSurname' => $this->nameSurname,
            'userType'    => $this->userType,
            'phoneNumber' => $this->phoneNumber,
            'email'       => $this->email,
            'password'    => $this->password,
            'influencers' => InfluencerResource::collection($this->whenLoaded('influencers'))
        ];
    }
}
