<?php

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

uses(\Tests\TestCase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh --seed');

    $this->superAdminUserToken = User::findOrFail(1)->createToken('secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
    $this->operatorUserToken = User::findOrFail(2)->createToken('secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;
});

afterEach(function(){
    Artisan::call('migrate:fresh');
});

it('can fetch all classroom', function () {
    Classroom::factory(3)->create();
    $classrooms = ClassroomResource::collection(Classroom::latest()->get());

    $this->getJson('api/v1/classroom', [
            'Authorization' => 'Bearer ' . $this->superAdminUserToken
        ])
        ->assertStatus(200)
        ->assertExactJson([
            'code_status' => 200,
            'msg_status' => 'Classrooms has been loaded',
            'data' => $classrooms
        ]);
});

it ('cannot fetch all classroom because not have that permission', function(){
    $this->getJson('api/v1/classroom', [
            'Authorization' => 'Bearer ' . $this->operatorUserToken
        ])
        ->assertStatus(403);
});

it('can fetch classroom', function() {
    $classroom = Classroom::factory()->create();

    $this->getJson('api/v1/classroom/' . $classroom->id, [
            'Authorization' => 'Bearer ' . $this->superAdminUserToken
        ])
        ->assertStatus(200)
        ->assertExactJson([
            'code_status' => 200,
            'msg_status' => 'Classroom has been loaded',
            'data' => ClassroomResource::make($classroom->load('students'))
        ]);
});

it('cannot fetch classroom because they dont have permission to do that', function() {
    $classroom = Classroom::factory()->create();

    $this->getJson('api/v1/classroom/' . $classroom->id, [
            'Authorization' => 'Bearer ' . $this->operatorUserToken
        ])
        ->assertStatus(403);
});

it('can create a new classroom', function(){
    $this->postJson('api/v1/classroom', 
            ['name' => 'XII RPL 2'], 
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Classroom has been added'
         ]);
});

it ('cannot create a new classroom because they dont have permission to do that', function(){
    $this->postJson('api/v1/classroom', 
            ['name' => 'XII RPL 2'], 
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it ('cannot create a new classroom because there an issue in a request', function(){
    $this->postJson('api/v1/classroom', 
            [], 
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can update a classroom', function(){
    $classroom = Classroom::factory()->create();

    $this->putJson('api/v1/classroom/' . $classroom->id,
            ['name' => 'XII RPL I'],
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Classroom has been updated'
         ]);
});

it ('cannot update a classroom because they dont have permission to do that', function(){
    $classroom = Classroom::factory()->create();

    $this->putJson('api/v1/classroom/' . $classroom->id,
            ['name' => 'XII RPL 1'],
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it ('cannot update a classroom because there an issue in a request', function(){
    $classroom = Classroom::factory()->create();

    $this->putJson('api/v1/classroom/' . $classroom->id, 
            [],
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can delete a classroom', function() {
    $classroom = Classroom::factory()->create();

    $this->deleteJson('api/v1/classroom/' . $classroom->id, 
            [],
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Classroom has been deleted'
         ]);
});

it('cannot delete a classroom because they dont have permission to do that', function() {
    $classroom = Classroom::factory()->create();

    $this->deleteJson('api/v1/classroom/' . $classroom->id, 
            [],
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});