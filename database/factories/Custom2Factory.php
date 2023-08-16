<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\GemPack::class, function (Faker $faker) {
    return [
    	'name'=>'Gem Pack '.Str::random(4),
    	'type'=>'Gems Pack',
    	'description'=>$faker->paragraph,
    	'amount'=>rand(1, 500),
    	'discount_taka'=>50,
    	// 'discount_gems'=>0,
    	'discount_coins'=>50,
    	'price_taka'=>30,
    	// 'price_gems'=>30,
		'price_coins'=>30,
    ];
});
