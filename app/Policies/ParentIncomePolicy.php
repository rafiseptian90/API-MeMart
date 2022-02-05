<?php

namespace App\Policies;

use App\Models\ParentIncome;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ParentIncomePolicy
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
        return $user->tokenCan('browse_parent_income') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentIncome  $parentIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ParentIncome $parentIncome)
    {
        return $user->tokenCan('read_parent_income') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->tokenCan('create_parent_income') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentIncome  $parentIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ParentIncome $parentIncome)
    {
        return $user->tokenCan('update_parent_income') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentIncome  $parentIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ParentIncome $parentIncome)
    {
        return $user->tokenCan('delete_parent_income') ? Response::allow() : Response::deny('Access Forbidden');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentIncome  $parentIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ParentIncome $parentIncome)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ParentIncome  $parentIncome
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ParentIncome $parentIncome)
    {
        //
    }
}
