<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SKU;
use Faker\Generator as Faker;

$factory->define(SKU::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'description' => $faker->text(100),
        'price' => $faker->randomFloat(2, 500),
    ];
});
