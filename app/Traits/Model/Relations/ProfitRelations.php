<?php

namespace App\Traits\Model\Relations;

use App\Models\Student;

trait ProfitRelations
{
    // many to many to Student
    public function students () {
        return $this->belongsToMany(Student::class, 'profit_students', 'profit_id', 'student_id')->withPivot(['date', 'amount'])->withTimestamps();
    }
}
