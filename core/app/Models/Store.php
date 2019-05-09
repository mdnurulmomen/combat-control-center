<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	public $incrementing = false;
	
	public function bundleComponents(){
		return $this->hasMany('App\Models\BundleComponent', 'bundle_packs_id', 'bundle_id');
	}
}
