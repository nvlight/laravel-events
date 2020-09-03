<?php

namespace App\Policies\Evento;

use App\Models\User;
use App\Models\Evento\EventoCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventoCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, EventoCategory $eventoCategory)
    {
        return $eventoCategory->evento->user_id === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, EventoCategory $eventoCategory)
    {
        return $eventoCategory->evento->user_id === $user->id;
    }

    public function delete(User $user, EventoCategory $eventoCategory)
    {
        return $eventoCategory->evento->user_id === $user->id;
    }

    public function restore(User $user, EventoCategory $eventoCategory)
    {
        //
    }

    public function forceDelete(User $user, EventoCategory $eventoCategory)
    {
        return $eventoCategory->evento->user_id === $user->id;
    }
}
