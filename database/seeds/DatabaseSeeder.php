<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(LangsTableSeeder::class);
        $this->call(PersonsTableSeeder::class);
        $this->call(TensesTableSeeder::class);
        $this->call(TenseDetailsTableSeeder::class);

        Model::reguard();
    }
}
