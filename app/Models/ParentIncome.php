<?php

namespace App\Models;

use App\Traits\Model\Relations\ParentIncomeRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentIncome extends Model
{
    use HasFactory, SoftDeletes, ParentIncomeRelations;

    protected $fillable = [
        'name',
        'score'
    ];
}
