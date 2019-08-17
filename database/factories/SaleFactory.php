<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sale;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        //
        'medicine_id'=>$faker->numberBetween(1,50),
        'date'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'quantity'=>$faker->numberBetween(1,100),
        'price'=>$faker->randomFloat(2,1,1000)
    ];
});