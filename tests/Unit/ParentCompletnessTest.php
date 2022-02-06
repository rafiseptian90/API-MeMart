<?php

use App\Models\ParentCompletness;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Role;

uses(\Tests\TestCase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh --seed');

    $this->superAdminUserToken = User::findOrFail(1)->createToken('secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
    $this->operatorUserToken = User::findOrFail(2)->createToken('secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;
});

afterEach(function(){
    Artisan::call('migrate:fresh');
});

it('can fetch all parent completness', function () {
    $this->getJson('api/v1/parent-completness', 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertJsonStructure(['code_status', 'msg_status', 'data']);
});

it('cannot fetch all parent completness cause they dont have that permission', function () {
    $this->getJson('api/v1/parent-completness', 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('can fetch parent completness', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->getJson('api/v1/parent-completness/' . $parentCompletness->id, 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertJsonStructure(['code_status', 'msg_status', 'data']);
});

it('cannot fetch parent completness cause they dont have that permission', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->getJson('api/v1/parent-completness/' . $parentCompletness->id, 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('can create a new parent completness', function(){
    $this->postJson('api/v1/parent-completness', 
            // Request Body
            ['type' => 'Blabla type', 'score' => 5],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Parent Completness has been added'
         ]);
});

it('cannot create a new parent completness cause they dont have that permission', function(){
    $this->postJson('api/v1/parent-completness', 
            // Request Body
            ['type' => 'Blabla type', 'score' => 5],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('cannot create a new parent completness cause there an issue in request body', function(){
    $this->postJson('api/v1/parent-completness', 
            // Request Body
            ['type' => 'Blabla type'],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can update a parent completness', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->putJson('api/v1/parent-completness/' . $parentCompletness->id,
            // Request Body 
            ['type' => 'Blabla updated type', 'score' => 5],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
        )
        ->assertStatus(200)
        ->assertExactJson([
            'code_status' => 200,
            'msg_status' => 'Parent Completness has been updated'
        ]);

});

it('cannot update a parent completness cause they dont have that permission', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->putJson('api/v1/parent-completness/' . $parentCompletness->id,
            // Request Body 
            ['type' => 'Blabla updated type', 'score' => 5],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
        )
        ->assertStatus(403);
});

it('cannot update a parent completness cause there an issue in request body', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->putJson('api/v1/parent-completness/' . $parentCompletness->id,
            // Request Body 
            ['score' => 5],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
        )
        ->assertStatus(422);
});

it('can delete parent completness', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->deleteJson('api/v1/parent-completness/' . $parentCompletness->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Parent Completness has been deleted'
         ]);
});

it('cannot delete parent completness cause they dont have that permission', function(){
    $parentCompletness = ParentCompletness::create(['type' => 'Blabla Type', 'score' => 5]);

    $this->deleteJson('api/v1/parent-completness/' . $parentCompletness->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});