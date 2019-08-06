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
          'start_time' => '2019-07-29 15:00:00',
          'end_time' => '2019-07-29 16:00:00',
          'status' => 'pending',
        ]);
    }
}
