<?php

use App\Models\Profit;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Role;

uses(\Tests\TestCase::class);

beforeEach(function(){
    Artisan::call('migrate:fresh --seed');

    $this->superAdminUserToken = User::findOrFail(1)->createToken('secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
    $this->operatorUserToken = User::findOrFail(2)->createToken('secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;
    $this->studentUserToken = User::findOrFail(3)->createToken('secret token', Role::STUDENT_PERMISSIONS)->plainTextToken;

    $this->profit = Profit::create(['amount' => 'More than Rp 500.000', 'score' => 10]);
});

afterEach(function(){
    Artisan::call('migrate:fresh');
});

it('can fetch all profit', function(){
    $this->getJson('api/v1/profit',
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

it('cannot fetch all profit cause they dont have that permission', function(){
    $this->getJson('api/v1/profit',
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('can fetch a profit', function(){
    $this->getJson('api/v1/profit/' . $this->profit->id, 
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

it('cannot fetch a profit cause they dont have that permission', function(){
    $this->getJson('api/v1/profit/' . $this->profit->id, 
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('can create a new profit', function(){
    $requests = [
        'amount' => 'More than Rp 5.000.000',
        'score' => 7
    ];

    $this->postJson('api/v1/profit', 
            // Request Body
            $requests,
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Profit has been added'
         ]);
});

it('cannot create a new profit cause they dont have that permission', function(){
    $requests = [
        'amount' => 'More than Rp 7.000.000',
        'score' => 7
    ];

    $this->postJson('api/v1/profit', 
            // Request Body
            $requests,
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('cannot create a new profit cause there an issue in request body', function(){
    $requests = [
        'amount' => 'More than Rp 100.000'
    ];

    $this->postJson('api/v1/profit', 
            // Request Body
            $requests,
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->operatorUserToken]
         )
         ->assertStatus(422);
});

it('can update a profit', function(){
    $requests = [
        'amount' => 'More than Rp 10.000.000',
        'score' => 5
    ];

    $this->putJson('api/v1/profit/' . $this->profit->id, 
            // Request Body
            $requests,
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit has been updated'
         ]);
});

it('cannot update a profit cause they dont have that permission', function(){
    $requests = [
        'amount' => 'More than Rp 120.000.000',
        'score' => 5
    ];

    $this->putJson('api/v1/profit/' . $this->profit->id, 
            // Request Body
            $requests,
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});

it('cannot update a profit cause there an issue in request body', function(){
    $requests = [
        'score' => 10
    ];

    $this->putJson('api/v1/profit/' . $this->profit->id, 
            // Request Body
            $requests,
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(422);
});

it('can delete a profit', function(){
    $this->deleteJson('api/v1/profit/' . $this->profit->id, 
            // Request Body
            [],
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->superAdminUserToken]
         )
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit has been deleted'
         ]);
});

it('cannot delete a profit cause they dont have that permission', function(){
    $this->deleteJson('api/v1/profit/' . $this->profit->id, 
            // Request Body
            [],
            // Request Header 
            ['Authorization' => 'Bearer ' . $this->studentUserToken]
         )
         ->assertStatus(403);
});