<?php

use App\Models\Admin;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
    	'firstname'=>Str::random(4),
        'lastname'=>Str::random(4),
        'username'=> $faker->name,
        'password'=> bcrypt('admin'),
        'is_verified'=> 1,
        'active'=> 1,
        'email'=> $faker->unique()->safeEmail,
        'phone'=>'0'.rand(6, 11),
        'address'=>'Address',
        'city'=>'Dhaka',
        'country'=>'Bangladesh'
    ];
});
