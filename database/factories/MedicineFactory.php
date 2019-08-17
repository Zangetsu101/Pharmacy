<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Medicine;
use Faker\Generator as Faker;

$factory->define(Medicine::class, function (Faker $faker) {
    return [
        //
        'name'=>$faker->text(30),
        'company_id'=>$faker->numberBetween(1,5),
        'generic_name'=>$faker->text(50),
        'dosage_form'=>$faker->text(20)
    ];
});
