<?php

namespace App\Policies;

use App\User;
use App\Client;
use App\Pet;
use Illuminate\Auth\Access\HandlesAuthorization;

class PetPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Pet $pet)
    {
      $user = auth()->user();
      $role = $user->roles()->pluck('id')->first();
      $client = Client::where('user_id', $user->id)->first();
      if ($role == 1 || $role == 2) {
        return true;
      } else if ($pet->client_id == $client->id) {
        return true;
      } else {
        return false;
      }
    }
}
