<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        return [
            'userId'=>'required'
        ];
    }

    public function sanitize()
    {
        if (!empty($this->facebookName)) {
            $this['username'] = $this->facebookName;
        }
        else{
            $this['username'] = $this->userName;
        }
        
        unset($this['userName']);

        $this['phone'] = $this->mobileNo;
        unset($this['mobileNo']);

        $this['email'] = $this->userEmail;
        unset($this['userEmail']);

        $this['location'] = $this->userLocation;
        unset($this['userLocation']);

        $this['facebook_id'] = $this->facebookId;
        unset($this['facebookID']);

        $this['facebook_name'] = $this->facebookName;
        unset($this['facebookName']);

        $this['profile_pic'] = $this->profilePic;
        unset($this['profilePic']);

        $this['connection_type'] = $this->connectionType;
        unset($this['connectionType']);

        if (empty($this->facebook_id)) {
            $this['device_info'] = $this->userDeviceId;
            $this['login_type'] = 'false';
        }
        else{
            $this['device_info'] = '';
            $this['login_type'] = 'true';
        }

        $this['player_batch'] = $this->playerBatch;
        unset($this['playerBatch']);

        $this['selected_parachute'] = $this->selectedParachute;
        unset($this['selectedParachute']);

        $this['selected_character'] = $this->selectedCharacter;
        unset($this['selectedCharacter']);

        $this['selected_animation'] = $this->selectedAnimation;
        unset($this['selectedAnimation']);

        $this['selected_weapon'] = $this->selectedWeapon;
        unset($this['selectedWeapon']);
    }
}
