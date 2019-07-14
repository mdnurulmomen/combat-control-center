<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function treasureType()
    {
    	return $this->belongsTo(TreasureType::class, 'treasure_type_id', 'id');
    }
}
