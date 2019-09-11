<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    return [
        'username'=> $faker->name,
        'password'=> bcrypt('admin'),
        'is_verified'=> 1,
        'active'=> 1,
        'email'=> $faker->unique()->safeEmail,
    ];
});
