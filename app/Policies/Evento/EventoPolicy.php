<?php

namespace App\Policies\Evento;

use App\Models\User;
use App\Models\Evento\Evento;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Evento $evento)
    {
        return $evento->user_id === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Evento $evento)
    {
        return $evento->user_id === $user->id;
    }

    public function delete(User $user, Evento $evento)
    {
        return $evento->user_id === $user->id;
    }

    public function restore(User $user, Evento $evento)
    {
       //
    }

    public function forceDelete(User $user, Evento $evento)
    {
        return $evento->user_id === $user->id;
    }
}
