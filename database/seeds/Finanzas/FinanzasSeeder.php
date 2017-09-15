<?php

use Illuminate\Database\Seeder;

class FinanzasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);

    }
}
