<?php

namespace App\Traits\Model\Relations;

use App\Models\Student;

trait ParentCompletnessRelations
{
    // Has Many to Student
    public function students () {
        return $this->hasMany(Student::class, 'parent_completness_id');
    }
}
