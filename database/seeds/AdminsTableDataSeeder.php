<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Seah Sheng Hong',
            'ic_no' => '980601086003',
            'address' => '31A, Jalan SL 7/3, Bandar Sungai Long, 43200 Kajang, Selangor.',
            'gender' => 'M',
            'birth_date' => '1998-06-01',
            'phone' => '0125207788',
            'user_id' => 1
        ]);
    }
}
