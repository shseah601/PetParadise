<?php

use Illuminate\Database\Seeder;
use App\Pet;

class PetsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pet::create([
            'name' => 'Kyle',
            'type' => 'dog',
            'gender' => 'M',
            'age' => '2',
            'client_id' => 1
        ]);
    }
}
