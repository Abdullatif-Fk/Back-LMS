<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attendance::create([
            'status' => 0,

        ]);
        Attendance::create([
            'status' => 1,
        ]);
        Attendance::create([

            'status' => 2,
        ]);
    }
}
