<?php

use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Artisan;

uses(\Tests\TestCase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh --seed');

    $this->superAdminUserToken = User::findOrFail(1)->createToken('secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
    $this->operatorUserToken = User::findOrFail(2)->createToken('secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;
    $this->studentUserToken = User::findOrFail(3)->createToken('secret token', Role::STUDENT_PERMISSIONS)->plainTextToken;
});

afterEach(function(){
    Artisan::call('migrate:fresh');
});

it('can fetch all student', function(){
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

it('cannot fetch all student cause they dont have that permission', function(){
    $this->getJson('api/v1/student', 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('can fetch a student', function(){
    $student = Student::factory()->create();

    $this->getJson('api/v1/student/' . $student->id, 
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

it('cannot fetch a student cause they dont have that permission', function(){
    $student = Student::factory()->create();

    $this->getJson('api/v1/student/' . $student->id, 
            // Request Body
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('can create a new student', function(){
    $requests = [
        'classroom_id' => 1,
        'parent_completness_id' => 1,
        'parent_income_id' => 1,
        'other_criteria_id' => 1,
        'name' => 'Rafi Septian Hadi',
        'card_number' => '201029200393',
        'card_type' => 'NISN',
        'gender' => 'M',
        'phone_number' => '087876478474',
        'address' => 'Jln. Blablabla'
    ];

    $this->postJson('api/v1/student', 
            // Request Body
            $requests,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Student has been added'
         ]);
});

it('cannot create a new student cause they dont have that permission', function(){
    $requests = [
        'classroom_id' => 1,
        'parent_completness_id' => 1,
        'parent_income_id' => 1,
        'other_criteria_id' => 1,
        'name' => 'Rafi Septian Hadi',
        'card_number' => '201029200393',
        'card_type' => 'NISN',
        'gender' => 'M',
        'phone_number' => '087876478474',
        'address' => 'Jln. Blablabla'
    ];

    $this->postJson('api/v1/student', 
            // Request Body
            $requests,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('cannot create a new student cause there an issue in request body', function(){
    $requests = [
        'classroom_id' => 1,
        'parent_completness_id' => 1,
        'parent_income_id' => 1,
        'other_criteria_id' => 1,
        'name' => 'Rafi Septian Hadi',
        'card_type' => 'NISN',
        'gender' => 'M',
        'phone_number' => '087876478474',
        'address' => 'Jln. Blablabla'
    ];

    $this->postJson('api/v1/student', 
            // Request Body
            $requests,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can update a student', function(){
    $requests = [
        'classroom_id' => 2,
        'parent_completness_id' => 2,
        'parent_income_id' => 2,
        'other_criteria_id' => 2,
        'name' => 'Rafi Septian Hadi',
        'card_number' => '201029200397',
        'card_type' => 'NISN',
        'gender' => 'M',
        'phone_number' => '087876478474',
        'address' => 'Jln. Blablabla'
    ];

    $student = Student::factory()->create();

    $this->putJson('api/v1/student/' . $student->id, 
            // Request Body
            $requests,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Student has been updated'
         ]);
});

it('cannot update a student cause they dont have that permission', function(){
    $requests = [
        'classroom_id' => 2,
        'parent_completness_id' => 2,
        'parent_income_id' => 2,
        'other_criteria_id' => 2,
        'name' => 'Rafi Septian Hadi',
        'card_number' => '201029207697',
        'card_type' => 'NISN',
        'gender' => 'M',
        'phone_number' => '087876478474',
        'address' => 'Jln. Blablabla'
    ];

    $student = Student::factory()->create();

    $this->putJson('api/v1/student/' . $student->id, 
            // Request Body
            $requests,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('cannot update a student cause there an issue in request body', function(){
    $requests = [
        'classroom_id' => 2,
        'parent_completness_id' => 2,
        'parent_income_id' => 2,
        'other_criteria_id' => 2,
        'name' => 'Rafi Septian Hadi',
        'card_type' => 'NISN',
        'gender' => 'M',
        'phone_number' => '087876478474',
        'address' => 'Jln. Blablabla'
    ];

    $student = Student::factory()->create();

    $this->putJson('api/v1/student/' . $student->id, 
            // Request Body
            $requests,
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can delete a student', function(){
    $student = Student::factory()->create();

    $this->deleteJson('api/v1/student/' . $student->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Student has been deleted'
         ]);
});

it('cannot delete a student caue they dont have that permission', function(){
    $student = Student::factory()->create();

    $this->deleteJson('api/v1/student/' . $student->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});