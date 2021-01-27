<?php

namespace App\Policies\Evento;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Evento\EventoTagValue;

class EventoTagValuePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, EventoTagValue $eventoTagValue)
    {
        return $eventoTagValue->tag->evento->user_id === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, EventoTagValue $eventoTagValue)
    {
        return $eventoTagValue->tag->evento->user_id === $user->id;
    }

    public function delete(User $user, EventoTagValue $eventoTagValue)
    {
        return $eventoTagValue->tag->evento->user_id === $user->id;
    }

    public function restore(User $user, EventoTagValue $eventoTagValue)
    {
        //$eventoTagValue
    }

    public function forceDelete(User $user, EventoTagValue $eventoTagValue)
    {
        return $eventoTagValue->tag->evento->user_id === $user->id;
    }
}
