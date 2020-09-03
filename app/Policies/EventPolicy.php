<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Event $event)
    {
        return $event->user_id === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Event $event)
    {
        //
    }

    public function delete(User $user, Event $event)
    {
        //
    }

    public function restore(User $user, Event $event)
    {
        //
    }

    public function forceDelete(User $user, Event $event)
    {
        //
    }
}
