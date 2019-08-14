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
        'employee_id' => 2,
        'service_id' => 2,
        'start_time' => '2019-07-28 15:00:00',
        'end_time' => '2019-07-28 16:00:00',
        'status' => 'accepted'
      ]);
    }
}
