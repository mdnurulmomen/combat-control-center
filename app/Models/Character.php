<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public static function boot()
	{
		parent::boot();

		static::created (
			function ($obj) {
		        $obj->custom_id = 'Chrctr_'.$obj->id;
		        $obj->save();
			}
		);

		static::saving (
			function ($obj) {
		        $obj->custom_id = 'Chrctr_'.$obj->id;
			}
		);
	}

 	public function playersWithThisCharacter(){
        return $this->hasMany('App\Models\PlayerCharacter');
    }
}
