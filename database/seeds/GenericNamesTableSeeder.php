<?php

use Illuminate\Database\Seeder;

class GenericNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $genericNames=factory(App\GenericName::class,50)->create();
    }
}
