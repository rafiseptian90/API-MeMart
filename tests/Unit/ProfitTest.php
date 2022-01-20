<?php

use App\Models\Profit;
use Database\Seeders\ProfitSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function(){
    $this->profit = Profit::create(['amount' => 'More than Rp 500.000', 'score' => 10]);
});

it('can fetch all profit (failed cause they are had a number in a string)', function(){
    $this->seed(ProfitSeeder::class);

    $this->getJson('api/v1/profit')
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
        ]);
});

it('can fetch a profit (failed cause they are had a number in a string)', function(){
    $this->getJson('api/v1/profit/' . $this->profit->id)
         ->assertStatus(200)
         ->assertJsonStructure([
            'code_status',
            'msg_status',
            'data'
       ]);
});

it('can create a new profit', function(){
    $requests = [
        'amount' => 'More than Rp 100.000',
        'score' => 7
    ];

    $this->postJson('api/v1/profit', $requests)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'New Profit has been added'
         ]);
});

it('can update a profit', function(){
    $requests = [
        'amount' => 'More than Rp 100.000',
        'score' => 5
    ];

    $this->putJson('api/v1/profit/' . $this->profit->id, $requests)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit has been updated'
         ]);
});

it('can delete a profit', function(){
    $this->deleteJson('api/v1/profit/' . $this->profit->id)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit has been deleted'
         ]);
});