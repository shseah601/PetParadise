<?php

use Illuminate\Database\Seeder;
use App\PendingBooking;

class PendingBookingsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PendingBooking::create([
          'client_id' => 1,
          'pet_id' => 1,
          'service_id' => 1,
          'start_time' => '2019-07-29 15:00:00',
          'end_time' => '2019-07-29 16:00:00',
          'status' => 'pending',
        ]);
        PendingBooking::create([
          'client_id' => 1,
          'pet_id' => 1,
          'service_id' => 2,
          'start_time' => '2019-07-30 13:00:00',
          'end_time' => '2019-07-30 14:00:00',
          'status' => 'pending',
        ]);
        PendingBooking::create([
          'client_id' => 1,
          'pet_id' => 1,
          'service_id' => 2,
          'start_time' => '2019-08-06 10:00:00',
          'end_time' => '2019-08-06 11:00:00',
          'status' => 'pending',
        ]);
        PendingBooking::create([
          'client_id' => 2,
          'pet_id' => 2,
          'service_id' => 1,
          'start_time' => '2019-08-27 12:00:00',
          'end_time' => '2019-08-27 13:00:00',
          'status' => 'pending',
        ]);
        PendingBooking::create([
          'client_id' => 1,
          'pet_id' => 1,
          'service_id' => 1,
          'start_time' => '2019-08-28 12:00:00',
          'end_time' => '2019-08-28 13:00:00',
          'status' => 'pending',
        ]);
    }
}
