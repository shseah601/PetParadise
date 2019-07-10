<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'name' => 'See Lem',
            'address' => '123, Taman See Lem, 41200 Lemur, See.',
            'phone' => '0182546582',
            'user_id' => 2
        ]);
    }
}
