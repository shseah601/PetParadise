<?php

use Illuminate\Database\Seeder;
use App\WorkingHour;

class WorkingHoursTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkingHour::create([
          'name' => 'Sunday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00',
          'status'=> false
        ]);
        WorkingHour::create([
          'name' => 'Monday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00',
          'status' => true
        ]);
        WorkingHour::create([
          'name' => 'Tuesday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00',
          'status' => true
        ]);
        WorkingHour::create([
          'name' => 'Wednesday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00',
          'status' => true
        ]);
        WorkingHour::create([
          'name' => 'Thursday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00',
          'status' => true
        ]);
        WorkingHour::create([
          'name' => 'Friday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00',
          'status' => true
        ]);
        WorkingHour::create([
          'name' => 'Saturday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00',
          'status' => false
        ]);
    }
}
