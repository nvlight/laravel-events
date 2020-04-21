<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShortUrl\ShortUrl;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShortUrlPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any short urls.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the short url.
     *
     * @param  \App\User  $user
     * @param  \App\ShortUrl  $shortUrl
     * @return mixed
     */
    public function view(User $user, ShortUrl $shortUrl)
    {
        // return $user->id === $shortUrl->user_id;
    }

    /**
     * Determine whether the user can create short urls.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the short url.
     *
     * @param  \App\User  $user
     * @param  \App\ShortUrl  $shortUrl
     * @return mixed
     */
    public function update(User $user, ShortUrl $shortUrl)
    {
        return $user->id === $shortUrl->user_id;
    }

    /**
     * Determine whether the user can delete the short url.
     *
     * @param  \App\User  $user
     * @param  \App\ShortUrl  $shortUrl
     * @return mixed
     */
    public function delete(User $user, ShortUrl $shortUrl)
    {
        return $user->id === $shortUrl->user_id;
    }

    /**
     * Determine whether the user can restore the short url.
     *
     * @param  \App\User  $user
     * @param  \App\ShortUrl  $shortUrl
     * @return mixed
     */
    public function restore(User $user, ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the short url.
     *
     * @param  \App\User  $user
     * @param  \App\ShortUrl  $shortUrl
     * @return mixed
     */
    public function forceDelete(User $user, ShortUrl $shortUrl)
    {
        //
    }
}
