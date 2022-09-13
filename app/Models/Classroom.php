<?php

namespace App\Models;

use App\Traits\Model\Relations\ClassroomRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory, SoftDeletes, ClassroomRelations;

    protected $fillable = ['name'];
}
