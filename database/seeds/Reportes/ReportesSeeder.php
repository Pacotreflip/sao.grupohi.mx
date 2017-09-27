<?php

use Illuminate\Database\Seeder;

class ReportesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SubcontratosSeeder::class);
    }
}
