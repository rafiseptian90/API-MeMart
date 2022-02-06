<?php

use App\Models\ParentIncome;
use Database\Seeders\ParentIncomeSeeder;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Role;

uses (\Tests\TestCase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh --seed');

    $this->superAdminUserToken = User::findOrFail(1)->createToken('secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
    $this->operatorUserToken = User::findOrFail(2)->createToken('secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;

    $this->parentIncome = ParentIncome::create(['amount' => 'More than Rp 5.000.000', 'score' => 1]);
});

afterEach(function(){
    Artisan::call('migrate:fresh');
});

it('can fetch all parent income', function(){
    $this->getJson('api/v1/parent-income', [
            'Authorization' => 'Bearer ' . $this->superAdminUserToken
         ])
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
        ]);
});

it('cannot fetch all parent income cause they dont have permission to do that', function(){
    $this->getJson('api/v1/parent-income', [
            'Authorization' => 'Bearer ' . $this->operatorUserToken
        ])
        ->assertStatus(403);
});

it('can fetch parent income', function(){
    $this->getJson('api/v1/parent-income/' . $this->parentIncome->id, [
            'Authorization' => 'Bearer ' . $this->superAdminUserToken
        ])
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
         ]);
});

it('cannot fetch parent income cause they dont have permission to do that', function(){
    $this->getJson('api/v1/parent-income/' . $this->parentIncome->id, [
            'Authorization' => 'Bearer ' . $this->operatorUserToken
        ])
         ->assertStatus(403);
});

it('can create a new parent income', function(){
    $this->postJson('api/v1/parent-income', 
            // Request Body
            ['amount' => 'More than Rp 7.000.000', 'score' => 1], 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Parent Income has been added'
         ]);
});

it('cannot create a new parent income cause they dont have permission to do that', function(){
    $this->postJson('api/v1/parent-income', 
            // Request Body
            ['amount' => 'More than Rp 7.000.000', 'score' => 1], 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('cannot create a new parent income cause there an issue in a request body', function(){
    $this->postJson('api/v1/parent-income', 
            // Request Body
            ['score' => 1], 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can update parent income', function(){
    $this->putJson('api/v1/parent-income/' . $this->parentIncome->id, 
            // Request Body
            ['amount' => 'Less than Rp 500.000', 'score' => 10],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Income has been updated'
         ]);
});

it('cannot update parent income cause they dont have permission to do that', function(){
    $this->putJson('api/v1/parent-income/' . $this->parentIncome->id, 
            // Request Body
            ['amount' => 'Less than Rp 500.000', 'score' => 10],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('cannot update parent income cause there an issue in a request body', function(){
    $this->putJson('api/v1/parent-income/' . $this->parentIncome->id, 
            // Request Body
            ['amount' => 'Less than Rp 500.000'],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can delete parent income', function(){
    $this->deleteJson('api/v1/parent-income/' . $this->parentIncome->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Income has been deleted'
         ]);
});

it('cannot delete parent income cause they dont have permission to do that', function(){
    $this->deleteJson('api/v1/parent-income/' . $this->parentIncome->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});