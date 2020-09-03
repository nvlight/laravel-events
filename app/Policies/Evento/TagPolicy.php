<?php

namespace App\Policies\Evento;

use App\Models\User;
use App\Models\Evento\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    public function restore(User $user, Tag $tag)
    {
        //
    }

    public function forceDelete(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }
}
