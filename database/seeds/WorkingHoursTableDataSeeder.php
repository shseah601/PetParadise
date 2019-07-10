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
          'day' => 'Sunday'
        ]);
        WorkingHour::create([
          'day' => 'Monday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00'
        ]);
        WorkingHour::create([
          'day' => 'Tuesday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00'
        ]);
        WorkingHour::create([
          'day' => 'Wednesday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00'
        ]);
        WorkingHour::create([
          'day' => 'Thursday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00'
        ]);
        WorkingHour::create([
          'day' => 'Friday',
          'start_time' => '08:00:00',
          'end_time' => '19:00:00'
        ]);
        WorkingHour::create([
          'day' => 'Saturday'
        ]);
    }
}
