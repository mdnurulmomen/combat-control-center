<?php

namespace App\Http\Resources\Player;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerUserDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'userName'=>$this->username,
            'userId'=>$this->id,
            'mobileNo'=>$this->phone,
            'userEmail'=>$this->email,
            'userLocation'=>$this->location,
            'profilePic'=>$this->profile_pic,
            'loginType'=>$this->login_type,
            'facebookId'=>$this->facebook_id
        ];
    }
}
