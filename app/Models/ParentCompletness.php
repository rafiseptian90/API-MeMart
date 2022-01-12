<?php

namespace App\Models;

use App\Traits\Model\Relations\ParentCompletnessRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentCompletness extends Model
{
    use HasFactory, SoftDeletes, ParentCompletnessRelations;

    protected $fillable = [
        'name',
        'score'
    ];

}
