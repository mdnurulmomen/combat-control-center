<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Message::class, function (Faker $faker) {
    return [
       	'title' => $faker->title,
        'body' => $faker->text
    ];
});
