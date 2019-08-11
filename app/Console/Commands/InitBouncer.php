<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bouncer;
use App\User;
use App\Booking;
use App\Client;
use App\Employee;

class InitBouncer extends Command
{ 
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:roles_abilities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles and abilities';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //roles
        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrator'
        ]);

        $employee = Bouncer::role()->create([
            'name' => 'employee',
            'title' => 'Employee'
        ]);
        $client = Bouncer::role()->create([
            'name' => 'client',
            'title' => 'Client'
        ]);

        //abilties
        $manageEmployees = Bouncer::ability()->create([
          'name' => 'manage-employees',
          'title' => 'Manage Employees'
        ]);
        $manageAdminPanel = Bouncer::ability()->create([
          'name' => 'manage-admin-panel',
          'title' => 'Manage Admin Panel'
        ]);
        $manageCompany = Bouncer::ability()->create([
          'name' => 'manage-company',
          'title' => 'Manage Company'
        ]);
        $manageBookings = Bouncer::ability()->create([
          'name' => 'manage-bookings',
          'title' => 'Manage Bookings'
        ]);
        $managePets = Bouncer::ability()->create([
          'name' => 'manage-pets',
          'title' => 'Manage Pets'
        ]);
        

        //assign abilities to roles
        Bouncer::allow($admin)->to($manageEmployees);
        Bouncer::allow($admin)->to($manageAdminPanel);
        Bouncer::allow($admin)->to($manageCompany);
        Bouncer::allow($admin)->to($manageBookings);
        Bouncer::allow($admin)->to($managePets);

        Bouncer::allow($employee)->to($manageAdminPanel);
        Bouncer::allow($employee)->to($manageBookings);
        Bouncer::allow($employee)->to($managePets);

        Bouncer::allow($client)->to($manageBookings);
        Bouncer::allow($client)->to($managePets);

        $user = User::where('email', 'shseah601@gmail.com')->first();
        Bouncer::assign($admin)->to($user);

        $user = User::where('email', 'melvinlai@gmail.com')->first();
        Bouncer::assign($employee)->to($user);

        $user = User::where('email', 'chuacc@gmail.com')->first();
        Bouncer::assign($employee)->to($user);

        $user = User::where('email', 'seelem@gmail.com')->first();
        Bouncer::assign($client)->to($user);

        $user = User::where('email', 'ruizhe@gmail.com')->first();
        Bouncer::assign($client)->to($user);
    }
}
