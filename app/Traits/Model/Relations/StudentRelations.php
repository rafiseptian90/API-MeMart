<?php

namespace App\Traits\Model\Relations;

use App\Models\Classroom;
use App\Models\OtherCriteria;
use App\Models\ParentCompletness;
use App\Models\ParentIncome;
use App\Models\Profile;
use App\Models\Profit;

trait StudentRelations
{
    // Belongs to Classroom
    public function classroom () {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    // Belongs to Profile
    public function profile () {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    // Belongs to Parent Completness
    public function parent_completness () {
        return $this->belongsTo(ParentCompletness::class, 'parent_completness_id');
    }

    // Belongs to Parent Income
    public function parent_income () {
        return $this->belongsTo(ParentIncome::class, 'parent_income_id');
    }

    // Belongs to Other Criteria
    public function other_criteria () {
        return $this->belongsTo(OtherCriteria::class, 'other_criteria_id');
    }

    // many to many to Profit
    public function profits () {
        return $this->belongsToMany(Profit::class, 'profit_students', 'student_id', 'profit_id')->withPivot(['date'])->withTimestamps();
    }
}
