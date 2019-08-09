<?php

namespace App\Policies;

use App\User;
use App\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Client $client)
    {
      $user = auth()->user();
      $role = $user->roles()->pluck('id')->first();
      if ($role == 1 || $role == 2) {
        return true;
      } else if ($user->id == $client->user_id) {
        return true;
      } else {
        return false;
      }
    }
}
