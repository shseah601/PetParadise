<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanyTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
          'name' => 'Pet Paradise',
          'phone' => '0325468745',
          'email' => 'petparadise@petparadise.com',
          'address' => 'Mid Valley Megamall, 1, Lingkaran Syed Putra, Mid Valley City, 59200 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
          'title' => 'At Pet Care Centre, We Are Dedicated To Provide The Highest Quality Of Services For Your Pet.',
          'description' => 'Your pets will get the best care and most comfortable from us. Experience our Pet Care Centre service and beautiful facilities that we hope can become your pet\'s home away from home.',
          'logo' => '/img/company/logo.png',
        ]);
    }
}
