<?php

namespace App\Policies;

use App\Models\ParentCompletness;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ParentCompletnessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->tokenCan('browse_parent_completness') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentCompletness  $parentCompletness
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ParentCompletness $parentCompletness)
    {
        return $user->tokenCan('read_parent_completness') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->tokenCan('create_parent_completness') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentCompletness  $parentCompletness
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ParentCompletness $parentCompletness)
    {
        return $user->tokenCan('update_parent_completness') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentCompletness  $parentCompletness
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ParentCompletness $parentCompletness)
    {
        return $user->tokenCan('delete_parent_completness') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentCompletness  $parentCompletness
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ParentCompletness $parentCompletness)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentCompletness  $parentCompletness
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ParentCompletness $parentCompletness)
    {
        //
    }
}
