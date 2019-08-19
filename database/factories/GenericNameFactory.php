<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GenericName;
use Faker\Generator as Faker;

$factory->define(GenericName::class, function (Faker $faker) {
    return [
        //
        'name'=>$faker->text(50)
    ];
});
