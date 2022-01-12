<?php

namespace App\Traits\Model\Relations;

use App\Models\Profile;

trait UserRelations
{
    // Has One to Profile
    public function profile () {
        return $this->hasOne(Profile::class, 'profile_id');
    }
}
