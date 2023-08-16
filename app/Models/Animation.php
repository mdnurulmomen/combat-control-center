<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animation extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public static function boot()
	{
		parent::boot();

		static::created (
			function ($obj) {
		        $obj->custom_id = 'Anmtn_'.$obj->id;
		        $obj->save();
			}
		);

		static::saving (
			function ($obj) {
		        $obj->custom_id = 'Anmtn_'.$obj->id;
			}
		);
	}

    public function playersWithThisAnimation()
    {
        return $this->hasMany('App\Models\PlayerAnimation');
    }
}
