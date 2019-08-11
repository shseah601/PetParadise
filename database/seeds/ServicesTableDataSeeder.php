<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
          'name' => 'Pet Grooming',
          'type' => 'Grooming',
          'price_min' => 30.00,
          'price_max' => 90.00,
          'description' => 'Want to keep your pet well-groomed without all the hassle? Your pet can relax in the comfort of our place while being pampered!',
          'image' => '/img/services/pet-grooming.png',
          'duration' => '1'
        ]);

        Service::create([
          'name' => 'Pet Boarding',
          'type' => 'Boarding',
          'price_min' => 50.00,
          'price_max' => 100.00,
          'description' => 'Pets that live in with us are pampered with luxurious private rooms, individual attention and exciting daily activities to keep them happy and healthy.',
          'image' => '/img/services/pet-grooming.png',
          'capacity' => '10'
        ]);
    }
}
