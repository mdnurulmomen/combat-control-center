<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guarded=['id'];
    use Notifiable;
}

//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Contracts\Auth\Authenticatable;
//use Illuminate\Auth\Authenticatable as AuthenticableTrait;

//class Admin extends Model implements Authenticatable
//{
//    use AuthenticableTrait;
//    protected $fillable = ['username', 'password'];
//}

//class Admin extends Model
//{
//
//}
