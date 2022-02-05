<?php

namespace App\Policies;

use App\Models\Profit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProfitPolicy
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
        return $user->tokenCan('browse_profit') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Profit $profit)
    {
        return $user->tokenCan('read_profit') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->tokenCan('create_profit') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Profit $profit)
    {
        return $user->tokenCan('update_profit') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Profit $profit)
    {
        return $user->tokenCan('delete_profit') ? Response::allow() : Response::deny('Action Denied');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Profit $profit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Profit $profit)
    {
        //
    }
}
