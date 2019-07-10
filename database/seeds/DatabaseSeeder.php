<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CompanyTableDataSeeder::class);
        $this->call(WorkingHoursTableDataSeeder::class);
        $this->call(UsersTableDataSeeder::class);
        $this->call(AdminsTableDataSeeder::class);
        $this->call(EmployeesTableDataSeeder::class);
        $this->call(ClientsTableDataSeeder::class);
        $this->call(PetsTableDataSeeder::class);

    }
}
