<?php

namespace App\Traits\Model\Relations;

use App\Models\Student;
use App\Models\User;

trait ProfileRelations
{
    // Has One to Student
    public function student () {
        return $this->hasOne(Student::class, 'profile_id');
    }

    // Belongs to User
    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }
}
