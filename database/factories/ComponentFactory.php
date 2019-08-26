<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Component;
use Faker\Generator as Faker;

$factory->define(Component::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'description' => $faker->text(100),
        'cost' => $faker->randomFloat(2, 1),
    ];
});
