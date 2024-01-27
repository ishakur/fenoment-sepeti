<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CorpAdvertiserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'corpAdvName' => $this->corpAdvName,
            'corpAdvAddress' => $this->corpAdvAddress,
            'taxNumber' => $this->taxNumber,
            'userID' => new UserResource(User::findOrFail($this->userID)),
        ];
    }
}
