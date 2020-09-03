<?php

namespace App\Policies\Evento;

use App\Models\User;
use App\Models\Evento\Attachment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Attachment $attachment)
    {
        return $user->id === $attachment->user_id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Attachment $attachment)
    {
        return $user->id === $attachment->user_id;
    }

    public function delete(User $user, Attachment $attachment)
    {
        return $user->id === $attachment->user_id;
    }

    public function restore(User $user, Attachment $attachment)
    {
        //
    }

    public function forceDelete(User $user, Attachment $attachment)
    {
        return $user->id === $attachment->user_id;
    }
}
