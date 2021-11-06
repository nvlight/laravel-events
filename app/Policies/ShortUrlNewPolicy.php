<?php

namespace App\Policies;

use App\Models\ShortUrl\ShortUrlsCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShortUrlNewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
    }

    public function view(User $user, ShortUrlsCategory $shortUrl)
    {
        //return $user->id === $shortUrl->user_id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, ShortUrlsCategory $shortUrl)
    {
        //return $user->id === $shortUrl->user_id;
    }

    public function delete(User $user, ShortUrlsCategory $ShortUrlsCategory)
    {
        return $user->id === $ShortUrlsCategory->user_id;
    }

    public function restore(User $user, ShortUrlsCategory $shortUrl)
    {
        //
    }

    public function forceDelete(User $user, ShortUrlsCategory $shortUrl)
    {
        //
    }
}
