<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DosageForm;
use Faker\Generator as Faker;

$factory->define(DosageForm::class, function (Faker $faker) {
    return [
        //
        'name'=>$faker->text(20)
    ];
});
