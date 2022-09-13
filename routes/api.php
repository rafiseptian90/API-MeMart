<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
    'namespace' => 'API',
], function () {
    // Auth endpoint
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('reset-password', 'AuthController@resetPassword');
        Route::get('me', 'AuthController@me');
    });

    // Classroom Resource
    Route::apiResource('classroom', 'ClassroomController');

    // Other Criteria Resource
    Route::apiResource('other-criteria', 'OtherCriteriaController');

    // Parent Income Resource
    Route::apiResource('parent-income', 'ParentIncomeController');

    // Parent Completness Resource
    Route::apiResource('parent-completness', 'ParentCompletnessController');

    // Profit Resource
    Route::apiResource('profit', 'ProfitController');

    // Student Resource
    Route::apiResource('student', 'StudentController');

    // Profit Student Resource
    Route::apiResource('profit-student', 'ProfitStudentController');
});
