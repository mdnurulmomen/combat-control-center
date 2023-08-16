<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Parachute::class, function (Faker $faker) {
    return [
        'name'=>Str::random(6).' Parachute',
        'type'=>'parachute',
        'description'=>$faker->paragraph,
        'discount_taka'=>35.5,
        'discount_gems'=>35.5,
        'discount_coins'=>35.5,
        'price_taka'=>rand(0,50),
        'price_gems'=>rand(0,50),
        'price_coins'=>rand(0,20)
    ];
});
