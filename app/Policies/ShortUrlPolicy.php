<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShortUrl\ShortUrl;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShortUrlPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
    }

    public function view(User $user, ShortUrl $shortUrl)
    {
        // return $user->id === $shortUrl->user_id;
        return true;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, ShortUrl $shortUrl)
    {
        return $user->id === $shortUrl->user_id;
    }

    public function delete(User $user, ShortUrl $shortUrl)
    {
        return $user->id === $shortUrl->user_id;
    }

    public function restore(User $user, ShortUrl $shortUrl)
    {
        //
    }

    public function forceDelete(User $user, ShortUrl $shortUrl)
    {
        //
    }
}
