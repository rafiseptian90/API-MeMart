<?php

namespace App\Policies;

use App\Models\OtherCriteria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OtherCriteriaPolicy
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
        return $user->tokenCan('browse_other_criteria') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OtherCriteria  $otherCriteria
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OtherCriteria $otherCriteria)
    {
        return $user->tokenCan('read_other_criteria') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->tokenCan('create_other_criteria') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OtherCriteria  $otherCriteria
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OtherCriteria $otherCriteria)
    {
        return $user->tokenCan('update_other_criteria') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OtherCriteria  $otherCriteria
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OtherCriteria $otherCriteria)
    {
        return $user->tokenCan('delete_other_criteria') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OtherCriteria  $otherCriteria
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, OtherCriteria $otherCriteria)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OtherCriteria  $otherCriteria
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, OtherCriteria $otherCriteria)
    {
        //
    }
}
