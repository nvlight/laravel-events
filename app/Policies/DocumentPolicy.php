<?php

namespace App\Policies;

use App\User;
use App\Models\Document\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function view(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        return $user->id === $document->user_id;
    }

    /**
     * Determine whether the user can restore the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function restore(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function forceDelete(User $user, Document $document)
    {
        //
    }
}
