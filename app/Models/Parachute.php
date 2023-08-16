<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parachute extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    
    public static function boot()
	{
		parent::boot();

		static::created (
			function ($obj) {
		        $obj->custom_id = 'Prcht_'.$obj->id;
		        $obj->save();
			}
		);

		static::saving (
			function ($obj) {
		        $obj->custom_id = 'Prcht_'.$obj->id;
			}
		);
	}

    public function playerWhoGotThis(){
        return $this->hasMany('App\Models\PlayerParachute');
    }
}
