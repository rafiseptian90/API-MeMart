<?php

use App\Http\Resources\ParentCompletnessResource;
use App\Models\ParentCompletness;
use Database\Seeders\ParentCompletnessSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

it('can fetch all parent completness', function () {
    $this->seed(ParentCompletnessSeeder::class);

    $this->getJson('api/v1/parent-completness')
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Completnesses has been loaded',
             'data' => ParentCompletnessResource::collection(ParentCompletness::latest()->get())
         ]);
});

it('can fetch parent completness', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->getJson('api/v1/parent-completness/' . $parentCompletness->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Completness has been loaded',
             'data' => ParentCompletnessResource::make($parentCompletness->load('students'))
         ]);
});

it('can create a new parent completness', function(){
    $this->postJson('api/v1/parent-completness', ['type' => 'Blabla type', 'score' => 5])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Parent Completness has been added'
         ]);
});

it('can update a parent completness', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->putJson('api/v1/parent-completness/' . $parentCompletness->id, ['type' => 'Blabla updated type', 'score' => 5])
        ->assertStatus(200)
        ->assertExactJson([
            'code_status' => 200,
            'msg_status' => 'Parent Completness has been updated'
        ]);

});

it('can delete parent completness', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->deleteJson('api/v1/parent-completness/' . $parentCompletness->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Completness has been deleted'
         ]);
});