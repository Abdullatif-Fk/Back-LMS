<?php

namespace Database\Seeders;

use Database\Seeders\AttendanceSeeder;
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
        $this->call(AttendanceSeeder::class);
    }
}
