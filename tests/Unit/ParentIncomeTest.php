<?php

use App\Http\Resources\ParentIncomeResource;
use App\Models\ParentIncome;
use Database\Seeders\ParentIncomeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses (\Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function(){
    $this->parentIncome = ParentIncome::create(['amount' => 'More than Rp 5.000.000', 'score' => 1]);
});

it('can fetch all parent income', function(){
    $this->seed(ParentIncomeSeeder::class);

    $this->getJson('api/v1/parent-income')
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
        ]);
});

it('can fetch parent income', function(){
    $this->getJson('api/v1/parent-income/' . $this->parentIncome->id)
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
         ]);
});

it('can create a new parent income', function(){
    $this->postJson('api/v1/parent-income', ['amount' => 'More than Rp 7.000.000', 'score' => 1])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Parent Income has been added'
         ]);
});

it('can update parent income', function(){
    $this->putJson('api/v1/parent-income/' . $this->parentIncome->id, ['amount' => 'Less than Rp 500.000', 'score' => 10])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Income has been updated'
         ]);
});

it('can delete parent income', function(){
    $this->deleteJson('api/v1/parent-income/' . $this->parentIncome->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Income has been deleted'
         ]);
});