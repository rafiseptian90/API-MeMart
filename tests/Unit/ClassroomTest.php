<?php

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

it('can fetch all classroom', function () {
    Classroom::factory(10)->create();
    $classrooms = ClassroomResource::collection(Classroom::latest()->get());

    $this->getJson('api/v1/classroom')
        ->assertStatus(200)
        ->assertExactJson([
            'code_status' => 200,
            'msg_status' => 'Classrooms has been loaded',
            'data' => $classrooms
        ]);
});

it('can fetch classroom', function() {
    $classroom = Classroom::factory()->create();

    $this->getJson('api/v1/classroom/' . $classroom->id)
        ->assertStatus(200)
        ->assertExactJson([
            'code_status' => 200,
            'msg_status' => 'Classroom has been loaded',
            'data' => ClassroomResource::make($classroom->load('students'))
        ]);
});

it('can create a new classroom', function(){
    $this->postJson('api/v1/classroom', ['name' => 'XII RPL 2'])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Classroom has been added'
         ]);
});

it('can update a classroom', function(){
    $classroom = Classroom::factory()->create();

    $this->putJson('api/v1/classroom/' . $classroom->id, ['name' => 'XII RPL I'])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Classroom has been updated'
         ]);
});

it('can delete a classroom', function() {
    $classroom = Classroom::factory()->create();

    $this->deleteJson('api/v1/classroom/' . $classroom->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Classroom has been deleted'
         ]);
});