<?php

namespace App\Policies;

use App\User;
use App\Client;
use App\Booking;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
  use HandlesAuthorization;

  public function view(User $user, Booking $booking)
  {
    $user = auth()->user();
    $role = $user->roles()->pluck('id')->first();
    $client = $user->client;
    if ($role == 1 || $role == 2) {
      return true;
    } else if ($booking->client_id == $client->id) {
      return true;
    } else {
      return false;
    }
  }

  public function update(User $user, Booking $booking)
  {
    $user = auth()->user();
    $role = $user->roles()->pluck('id')->first();
    $client = $user->client;
    if ($role == 1 || $role == 2) {
      return true;
    } else if ($booking->client_id == $client->id) {
      return true;
    } else {
      return false;
    }
  }

}
