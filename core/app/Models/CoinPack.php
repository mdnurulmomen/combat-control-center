<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinPack extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public static function boot()
	{
		parent::boot();

		static::created (
			function ($obj) {
		        $obj->custom_id = 'CnsPck_'.$obj->id;
		        $obj->save();
			}
		);

		static::saving (
			function ($obj) {
		        $obj->custom_id = 'CnsPck_'.$obj->id;
			}
		);
	}

 
}
