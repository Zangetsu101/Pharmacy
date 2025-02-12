<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(DosageFormsTableSeeder::class);
        $this->call(GenericNamesTableSeeder::class);
        $this->call(PricesTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
    }
}
