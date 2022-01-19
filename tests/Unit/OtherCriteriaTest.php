<?php

use App\Http\Resources\OtherCriteriaResource;
use App\Models\OtherCriteria;
use Database\Seeders\OtherCriteriaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function(){
    $this->otherCriteria = OtherCriteria::create(['name' => 'Blabla name', 'score' => 3]);
});

it('can fetch all other criteria', function(){
    $this->seed(OtherCriteriaSeeder::class);

    $this->getJson('api/v1/other-criteria')
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criterias has been loaded',
             'data' => OtherCriteriaResource::collection(OtherCriteria::latest()->get())
         ]);
});

it('can fetch other criteria', function(){
    $this->getJson('api/v1/other-criteria/' . $this->otherCriteria->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criteria has been loaded',
             'data' => OtherCriteriaResource::make($this->otherCriteria->load('students'))
         ]);
});

it('can create a new other criteria', function(){
    $this->postJson('api/v1/other-criteria', ['name' => 'Blabla other criteria', 'score' => 1])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Other Criteria has been added'
         ]);
});

it('can update an other criteria', function(){
    $this->putJson('api/v1/other-criteria/' . $this->otherCriteria->id, ['name' => 'Blabla other criteria', 'score' => 1])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criteria has been updated'
         ]);
});

it('can delete an other criteria', function(){
    $this->deleteJson('api/v1/other-criteria/' . $this->otherCriteria->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criteria has been deleted'
         ]);
});