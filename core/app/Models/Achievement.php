<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $guarded = ['id'];

    public static function boot()
	{
		parent::boot();

		static::created (
			function ($obj) {
		        $obj->custom_id = 'Achievement_'.$obj->id;
		        $obj->save();
			}
		);

		static::saving (
			function ($obj) {
		        $obj->custom_id = 'Achievement_'.$obj->id;
			}
		);
	}
}
