<?php

namespace App\Policies;

use App\User;
use App\Client;
use App\PendingBooking;
use Illuminate\Auth\Access\HandlesAuthorization;

class PendingBookingPolicy
{
    use HandlesAuthorization;

    public function view(User $user, PendingBooking $pendingBooking)
    {
      $user = auth()->user();
      $role = $user->roles()->pluck('id')->first();
      $client = $user->client;
      if ($role == 1 || $role == 2) {
        return true;
      } else if ($pendingBooking->client_id == $client->id) {
        return true;
      } else {
        return false;
      }
    }
}
