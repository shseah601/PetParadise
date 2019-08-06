<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'shseah601@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        User::create([
          'email' => 'seelem@gmail.com',
          'password' => bcrypt('123456789')
        ]);
        User::create([
          'email' => 'chuacc@gmail.com',
          'password' => bcrypt('123456789')
        ]);
        User::create([
          'email' => 'melvinlai@gmail.com',
          'password' => bcrypt('123456789')
        ]);
        User::create([
          'email' => 'ruizhe@gmail.com',
          'password' => bcrypt('123456789')
        ]);
    }
}
