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
            'name' => 'Seah Sheng Hong',
            'email' => 'shseah601@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        User::create([
          'name' => 'See Lem',
          'email' => 'seelem@gmail.com',
          'password' => bcrypt('123456789')
        ]);
        User::create([
          'name' => 'Chua Chang Chyuan',
          'email' => 'chuacc@gmail.com',
          'password' => bcrypt('123456789')
        ]);
        User::create([
          'name' => 'Melvin Lai',
          'email' => 'melvinlai@gmail.com',
          'password' => bcrypt('123456789')
        ]);
        User::create([
          'name' => 'Rui Zhe',
          'email' => 'ruizhe@gmail.com',
          'password' => bcrypt('123456789')
        ]);
    }
}
