<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
          'name' => 'Chua Chang Chyuan',
          'ic_no' => '930622024563',
          'address' => '22, Taman CC, 43000 KLCC, Kuala Lumpur.',
          'gender' => 'M',
          'birth_date' => '1993-06-22',
          'phone' => '0165485487',
          'user_id' => 3
        ]);
        Employee::create([
          'name' => 'Melvin Lai',
          'ic_no' => '960125056527',
          'address' => '22, Taman CC, 43000 KLCC, Kuala Lumpur.',
          'gender' => 'M',
          'birth_date' => '1996-01-25',
          'phone' => '0135685245',
          'user_id' => 4
        ]);
    }
}
