<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\ClassroomSeeder;
use Database\Seeders\OtherCriteriaSeeder;
use Database\Seeders\ParentCompletnessSeeder;
use Database\Seeders\ParentIncomeSeeder;
use Database\Seeders\ProfileSeeder;
use Illuminate\Support\Facades\Artisan;

uses(\Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh', ['--seed' => '']);

    User::factory(10)->create();
    $this->seed(ProfileSeeder::class);
    $this->seed(ParentCompletnessSeeder::class);
    $this->seed(ParentIncomeSeeder::class);
    $this->seed(ClassroomSeeder::class);
    $this->seed(OtherCriteriaSeeder::class);
});

it('can fetch all student', function(){
    $this->getJson('api/v1/student')
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
         ]);
});

it('can fetch a student', function(){
    $student = Student::factory()->create();

    $this->getJson('api/v1/student/' . $student->id)
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
         ]);
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

    $this->postJson('api/v1/student', $requests)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Student has been added'
         ]);

});

it('can update a student', function(){
    $requests = [
        'classroom_id' => 2,
        'parent_completness_id' => 2,
        'parent_income_id' => 2,
        'other_criteria_id' => 2,
        'name' => 'Rafi Septian Hadi',
        'card_number' => '201029200393',
        'card_type' => 'NISN',
        'gender' => 'M',
        'phone_number' => '087876478474',
        'address' => 'Jln. Blablabla'
    ];

    $student = Student::factory()->create();

    $this->putJson('api/v1/student/' . $student->id, $requests)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Student has been updated'
         ]);
});

it('can delete a student', function(){
    $student = Student::factory()->create();

    $this->deleteJson('api/v1/student/' . $student->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Student has been deleted'
         ]);
});