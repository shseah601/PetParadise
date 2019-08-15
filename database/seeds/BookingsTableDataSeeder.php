<?php

use Illuminate\Database\Seeder;
use App\Booking;

class BookingsTableDataSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Booking::create([
      'client_id' => 2,
      'pet_id' => 2,
      'employee_id' => 1,
      'service_id' => 2,
      'start_time' => '2019-07-28 00:00:00',
      'end_time' => '2019-07-29 00:00:00',
      'status' => 'accepted'
    ]);
    Booking::create([
      'client_id' => 2,
      'pet_id' => 2,
      'employee_id' => 2,
      'service_id' => 1,
      'start_time' => '2019-08-15 15:00:00',
      'end_time' => '2019-08-15 16:00:00',
      'status' => 'accepted'
    ]);
    Booking::create([
      'client_id' => 1,
      'pet_id' => 1,
      'employee_id' => 2,
      'service_id' => 1,
      'start_time' => '2019-08-15 12:00:00',
      'end_time' => '2019-08-15 13:00:00',
      'status' => 'accepted'
    ]);
  }
}
