<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgencyResource extends JsonResource
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
        return [
            'agencyName' => $this->agencyName,
            'agencyAddress' => $this->agencyAddress,
            'taxNumber' => $this->taxNumber,
            'users' => new UserResource(User::findOrFail($this->userID)),
        ];
    }
}
