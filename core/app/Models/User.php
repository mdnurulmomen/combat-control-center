<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $table = 'users';

    public function player()
    {
        return $this->hasOne('App\Models\Player');
    }

    public function scopeTakenFacebookId($query, $facebookId)
    {	
		return $query->whereNotNull('facebook_id')->where('facebook_id', $facebookId);	
    }

    /*public function scopeTakenGmailId($query, $gmailId)
    {
    	return $query->where('gmail_id', $gmailId);
    }*/

    public function scopeTakenMobileNo($query, $mobileNo)
    {		
    	return $query->whereNotNull('phone')->where('phone', $mobileNo);
    }

	public function scopeTakenDeviceId($query, $deviceId)
    {	
    	return $query->whereNotNull('device_info')->where('device_info', $deviceId);	
    }

}
