<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\BoostPack::class, function (Faker $faker) {
    return [
        'name'=>$faker->randomElement(['Ammo Boost', 'Melee Boost', 'Heavy Boost', 'Light Boost', 'Armor Boost', 'Range Boost']),
        'type'=>'Boost Pack',
        'description'=>$faker->paragraph,
        'amount'=>rand(1, 500),
        'discount_taka'=>60,
        'discount_gems'=>60,
        'discount_coins'=>60,
        'price_taka'=>30,
        'price_gems'=>30,
        'price_coins'=>30
    ];
});
