<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    public function setUserRegistrationAttribute($value)
    {
    	if (Str::is('on', $value))
    		$this->attributes['user_registration'] = 1;

    	else
    		$this->attributes['user_registration'] = 0;
    }

    public function setEmailVerificationAttribute($value)
    {
    	if (Str::is('on', $value))
    		$this->attributes['email_verification'] = 1;

    	else
    		$this->attributes['email_verification'] = 0;
    }

    public function setSmsVerificationAttribute($value)
    {
    	if (Str::is('on', $value))
    		$this->attributes['sms_verification'] = 1;

    	else
    		$this->attributes['sms_verification'] = 0;
    }
}
