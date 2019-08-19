<?php

use Illuminate\Database\Seeder;

class DosageFormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dosageForms=factory(App\DosageForm::class,5)->create();
    }
}
