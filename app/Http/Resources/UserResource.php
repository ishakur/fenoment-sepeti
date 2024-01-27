<?php

namespace App\Http\Resources;

use App\Enum\UserTypes;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [
            'userID'       => $this->userID,
            'nameSurname'  => $this->nameSurname,
            'email'        => $this->email,
            //            'phoneNumber'   => $this->userVerifications->phoneNumber,
            'profilePhoto' => $this->profilePhoto,
            'userType'     => $this->userType,
            'balance'      => $this->balance,
            //            'lastLoginDate' => $this->userVerifications->lastLoginDate,
            //            'registerDate'  => $this->userVerifications->registerDate,
        ];
    }
}
