<?php

namespace App\Models;

use App\Traits\Model\Relations\ProfitRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profit extends Model
{
    use HasFactory, SoftDeletes, ProfitRelations;

    protected $casts = [
        'amount' => 'string'
    ];

    protected $fillable = [
        'amount',
        'score'
    ];
}
