<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Price;
use Faker\Generator as Faker;

$factory->define(Price::class, function (Faker $faker) {
    return [
        //
        'medicine_id'=>factory('App\Medicine')->create()->id,
        'from'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'till'=>null,
        'wholesale_price'=>$faker->randomFloat(2,1,1000),
        'retail_price'=>$faker->randomFloat(2,1,1000)
    ];
});
