<?php

namespace App\Policies\Evento;

use App\Models\User;
use App\Models\Evento\EventoTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventoTagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, EventoTag $eventoTag)
    {
        return $eventoTag->evento->user_id === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, EventoTag $eventoTag)
    {
        return $eventoTag->evento->user_id === $user->id;
    }

    public function delete(User $user, EventoTag $eventoTag)
    {
        return $eventoTag->evento->user_id === $user->id;
    }

    public function restore(User $user, EventoTag $eventoTag)
    {
        //
    }

    public function forceDelete(User $user, EventoTag $eventoTag)
    {
        return $eventoTag->evento->user_id === $user->id;
    }
}
