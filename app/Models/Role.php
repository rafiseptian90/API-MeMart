<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    const SUPER_ADMIN_PERMISSIONS  = [
        // Classroom permissions
        'access_classroom',
        'browse_classroom',
        'create_classroom',
        'read_classroom',
        'update_classroom',
        'delete_classroom',

        // Parent Completness permissions
        'access_parent_completness',
        'browse_parent_completness',
        'create_parent_completness',
        'read_parent_completness',
        'update_parent_completness',
        'delete_parent_completness',

        // Parent Income permissions
        'access_parent_income',
        'browse_parent_income',
        'create_parent_income',
        'read_parent_income',
        'update_parent_income',
        'delete_parent_income',

        // Other Criteria permissions
        'access_other_criteria',
        'browse_other_criteria',
        'create_other_criteria',
        'read_other_criteria',
        'update_other_criteria',
        'delete_other_criteria',

        // Student permissions
        'access_student',
        'browse_student',
        'create_student',
        'read_student',
        'update_student',
        'delete_student',

        // Profit permissions
        'access_profit',
        'browse_profit',
        'create_profit',
        'read_profit',
        'update_profit',
        'delete_profit',

        // Profit Student permissions
        'access_profit_student',
        'browse_profit_student',
        'create_profit_student',
        'read_profit_student',
        'update_profit_student',
        'delete_profit_student',
    ];

    const OPERATOR_PERMISSIONS = [
        // Profit permissions
        'access_profit',
        'browse_profit',
        'read_profit',

        // Student permissions
        'access_student',
        'browse_student',
        'read_student',

        // Profit Student permissions
        'access_profit_student',
        'browse_profit_student',
        'create_profit_student',
        'read_profit_student',
        'update_profit_student',
        'delete_profit_student',
    ];

    const SUPER_ADMIN_ID = 1;
    const OPERATOR_ID = 2;
    const STUDENT_ID = 3;

    protected $fillable = [
        'name'
    ];
}
