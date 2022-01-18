<?php

namespace App\Models;

use App\Traits\Model\Relations\ProfileRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes, ProfileRelations;

    protected $fillable = [
        'user_id',
        'name',
        'card_number',
        'card_type',
        'phone_number',
        'gender',
        'address',
        'photo'
    ];
}
