<?php

namespace App\Policies\Evento;

use App\Models\User;
use App\Models\Evento\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Category $category)
    {
        return $category->user_id === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Category $category)
    {
        return $category->user_id === $user->id;
    }

    public function delete(User $user, Category $category)
    {
        return $category->user_id === $user->id;
    }

    public function restore(User $user, Category $category)
    {

    }

    public function forceDelete(User $user, Category $category)
    {
        return $category->user_id === $user->id;
    }
}
