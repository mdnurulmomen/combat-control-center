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
}
