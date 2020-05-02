<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Document $document)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Document $document)
    {
        //
    }

    public function delete(User $user, Document $document)
    {
        return $user->id === $document->user_id;
    }

    public function restore(User $user, Document $document)
    {
        //
    }

    public function forceDelete(User $user, Document $document)
    {
        //
    }
}
