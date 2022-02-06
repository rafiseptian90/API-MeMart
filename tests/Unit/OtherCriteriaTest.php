<?php

use App\Http\Resources\OtherCriteriaResource;
use App\Models\OtherCriteria;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Role;

uses(\Tests\TestCase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh --seed');

    $this->superAdminUserToken = User::findOrFail(1)->createToken('secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
    $this->operatorUserToken = User::findOrFail(2)->createToken('secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;

    $this->otherCriteria = OtherCriteria::create(['name' => 'Blabla name', 'score' => 3]);
});

afterEach(function(){
    Artisan::call('migrate:fresh');
});

it('can fetch all other criteria', function(){
    $this->getJson('api/v1/other-criteria', 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criterias has been loaded',
             'data' => OtherCriteriaResource::collection(OtherCriteria::latest()->get())
         ]);
});

it('cannot fetch all other criteria cause they dont have that permission', function(){
    $this->getJson('api/v1/other-criteria', 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('can fetch other criteria', function(){
    $this->getJson('api/v1/other-criteria/' . $this->otherCriteria->id, 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criteria has been loaded',
             'data' => OtherCriteriaResource::make($this->otherCriteria->load('students'))
         ]);
});

it('cannot fetch other criteria cause they dont have that permission', function(){
    $this->getJson('api/v1/other-criteria/' . $this->otherCriteria->id, 
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('can create a new other criteria', function(){
    $this->postJson('api/v1/other-criteria', 
            // Request Body
            ['name' => 'Blabla other criteria', 'score' => 1],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Other Criteria has been added'
         ]);
});

it('cannot create a new other criteria cause they dont have that permission', function(){
    $this->postJson('api/v1/other-criteria', 
            // Request Body
            ['name' => 'Blabla other criteria', 'score' => 1],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('cannot create a new other criteria cause there an issue in a request body', function(){
    $this->postJson('api/v1/other-criteria', 
            // Request Body
            ['score' => 1],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can update an other criteria', function(){
    $this->putJson('api/v1/other-criteria/' . $this->otherCriteria->id, 
            // Request Body
            ['name' => 'Blabla other criteria', 'score' => 1],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criteria has been updated'
         ]);
});

it('cannot update an other criteria cause they dont have that permission', function(){
    $this->putJson('api/v1/other-criteria/' . $this->otherCriteria->id, 
            // Request Body
            ['name' => 'Blabla other criteria', 'score' => 1],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});

it('cannot update an other criteria cause there an issue in a request body', function(){
    $this->putJson('api/v1/other-criteria/' . $this->otherCriteria->id, 
            // Request Body
            ['name' => 'Blabla other criteria'],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can delete an other criteria', function(){
    $this->deleteJson('api/v1/other-criteria/' . $this->otherCriteria->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Other Criteria has been deleted'
         ]);
});

it('cannot delete an other criteria cause they dont have that permission', function(){
    $this->deleteJson('api/v1/other-criteria/' . $this->otherCriteria->id, 
            // Request Body
            [],
            // Request Header
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(403);
});