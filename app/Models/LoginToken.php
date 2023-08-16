<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{
   	protected $guarded = ['id'];

   	public function tokenable()
   	{
   		return $this->morphTo();
   	}
}
