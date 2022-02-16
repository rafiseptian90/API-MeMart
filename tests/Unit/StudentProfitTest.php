<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Role;

uses(Tests\TestCase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh --seed');

    $this->superAdminUserToken = User::findOrFail(1)->createToken('secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
    $this->operatorUserToken = User::findOrFail(2)->createToken('secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;
    $this->studentUserToken = User::findOrFail(3)->createToken('secret token', Role::STUDENT_PERMISSIONS)->plainTextToken;
});

afterEach(function(){
    Artisan::call('migrate:fresh');
});

it ('can fetch all student by classroom', function(){
    $this->getJson('api/v1/student',
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
         ]);
});

it ('cannot fetch all student by classroom cause they dont have that permission', function(){
    $this->getJson('api/v1/student',
            // Request Header
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('can bulk create student profit', function(){
    $requests = [
        [
            'student_id' => 1,
            'profit_id' => 1,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 45000
        ],
        [
            'student_id' => 2,
            'profit_id' => 2,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 75000
        ],
        [
            'student_id' => 3,
            'profit_id' => 3,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 120000
        ]
    ];

    $this->postJson('api/v1/profit-student',
            // Request Body
            ['profit_students' => $requests],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit Students has been stored'
         ]);
});

it('cannot create a student profit cause they dont have that permission', function(){
    $requests = [
        [
            'student_id' => 1,
            'profit_id' => 1,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 45000
        ],
        [
            'student_id' => 2,
            'profit_id' => 2,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 75000
        ],
        [
            'student_id' => 3,
            'profit_id' => 3,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 120000
        ]
    ];

    $this->postJson('api/v1/profit-student',
            // Request Body
            ['profit_students' => $requests],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('cannot create a student profit cause the request body is empty', function(){
    $this->postJson('api/v1/profit-student',
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it ('can show a profit student', function(){
    $this->getJson('api/v1/profit-student/1',
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertJsonStructure(['code_status', 'msg_status', 'data']);
});

it ('can update a profit student', function(){
    $request = [
        'student_id' => 1,
        'profit_id' => 1,
        'date' => Carbon::now()->format('Y-m-d'),
        'amount' => 40000
    ];

    $this->putJson('api/v1/profit-student/1',
            // Request Body
            $request,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit Student has been updated'
         ]);

});

it ('cannot update a profit student cause they dont have that permission', function(){
    $request = [
        'student_id' => 1,
        'profit_id' => 1,
        'date' => Carbon::now()->format('Y-m-d'),
        'amount' => 40000
    ];

    $this->putJson('api/v1/profit-student/1',
            // Request Body
            $request,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it ('cannot update a profit student cause the request body is empty', function(){
    $this->putJson('api/v1/profit-student/1',
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it ('can delete a profit student', function(){
    $this->deleteJson('api/v1/profit-student/1?date=' . Carbon::now()->format('Y-m-d'),
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit Student has been deleted'
         ]);
});

it ('cannot delete a profit student cause they dont have that permission', function(){
    $this->deleteJson('api/v1/profit-student/1?date=' . Carbon::now()->format('Y-m-d'),
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});
