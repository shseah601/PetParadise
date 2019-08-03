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
        Pet::create([
          'name' => 'Lucky',
          'type' => 'dog',
          'gender' => 'F',
          'age' => '3',
          'client_id' => 2
      ]);
    }
}
