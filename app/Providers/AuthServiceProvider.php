<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Booking;
use App\Policies\BookingPolicy;
use App\Client;
use App\Policies\ClientPolicy;
use App\PendingBooking;
use App\Policies\PendingBookingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Client::class => ClientPolicy::class,
        PendingBooking::class => PendingBookingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
