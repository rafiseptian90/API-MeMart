<?php

namespace App\Models;

use App\Traits\Model\Relations\OtherCriteriaRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherCriteria extends Model
{
    use HasFactory, SoftDeletes, OtherCriteriaRelations;

    protected $fillable = [
        'name',
        'score'
    ];
}
