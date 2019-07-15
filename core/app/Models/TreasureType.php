<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreasureType extends Model
{
    use SoftDeletes;

    public function relatedTreasures()
    {
    	return $this->hasMany('App\Models\Treasure', 'treasure_type_id', 'id');
    }

    public function relatedVendors()
    {
    	return $this->hasMany(Vendor::class, 'treasure_type_id', 'id');
    }
}
