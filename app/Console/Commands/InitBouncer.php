<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bouncer;
use App\User;

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
        $manageUsers = Bouncer::ability()->create([
            'name' => 'manage-users',
            'title' => 'Manage Users'
        ]);
        $manageAdminPanel = Bouncer::ability()->create([
          'name' => 'manage-admin-panel',
          'title' => 'Manage Admin Panel'
        ]);
        $makeBooking = Bouncer::ability()->create([
          'name' => 'make-booking',
          'title' => 'Make booking'
        ]);

        //assign abilities to roles
        Bouncer::allow($admin)->to($manageUsers);
        Bouncer::allow($admin)->to($manageAdminPanel);
        Bouncer::allow($admin)->to($makeBooking);

        Bouncer::allow($admin)->to($manageAdminPanel);
        Bouncer::allow($admin)->to($makeBooking);

        Bouncer::allow($admin)->to($makeBooking);

        $user = User::where('email', 'shseah601@gmail.com')->first();
        Bouncer::assign($admin)->to($user);

        $user = User::where('email', 'melvinlai@gmail.com')->first();
        Bouncer::assign($employee)->to($user);

        $user = User::where('email', 'chuacc@gmail.com')->first();
        Bouncer::assign($employee)->to($user);

        $user = User::where('email', 'seelem@gmail.com')->first();
        Bouncer::assign($admin)->to($user);
    }
}
