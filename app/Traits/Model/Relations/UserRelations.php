<?php

namespace App\Traits\Model\Relations;

use App\Models\Profile;
use App\Models\Role;

trait UserRelations
{
    // Has One to Profile
    public function profile () {
        return $this->hasOne(Profile::class, 'profile_id');
    }

    // Belongs to Role
    public function role () {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
