<?php

namespace App\Traits\Model\Relations;

use App\Models\Student;

trait ParentIncomeRelations
{
    // Has Many to Student
    public function students () {
        return $this->hasMany(Student::class, 'parent_income_id');
    }
}
