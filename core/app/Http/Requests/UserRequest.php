<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
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
            'userId'=>'required|exists:users,id'
        ];
    }

    public function sanitize()
    {
        if (!empty($request->facebookName)) {
            $request['username'] = $request->facebookName;
        }
        else{
            $request['username'] = $request->userName;
        }
        
        unset($request['userName']);

        $request['email'] = $request->userEmail;
        unset($request['userEmail']);

        $request['location'] = $request->userLocation;
        unset($request['userLocation']);

        $request['facebook_id'] = $request->facebookId;
        unset($request['facebookId']);

        $request['facebook_name'] = $request->facebookName;
        unset($request['facebookName']);

        $request['profile_pic'] = $request->profilePic;
        unset($request['profilePic']);

        $request['connection_type'] = $request->connectionType;
        unset($request['connectionType']);

        /*
        if (empty($request->facebook_id)) {
            $request['device_info'] = $request->userDeviceId;
            $request['login_type'] = 'false';
        }
        else{
            $request['device_info'] = '';
            $request['login_type'] = 'true';
        }
        */

        $request['player_batch'] = $request->playerBatch;
        unset($request['playerBatch']);

        $request['selected_parachute'] = $request->selectedParachute;
        unset($request['selectedParachute']);

        $request['selected_character'] = $request->selectedCharacter;
        unset($request['selectedCharacter']);

        $request['selected_animation'] = $request->selectedAnimation;
        unset($request['selectedAnimation']);

        $request['selected_weapon'] = $request->selectedWeapon;
        unset($request['selectedWeapon']);
    }
}
