<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

uses(Tests\TestCase::class);

it ('can fetch all student by classroom', function(){
    $this->getJson('api/v1/student')
         ->assertStatus(200)
         ->assertJsonStructure([
             'code_status',
             'msg_status',
             'data'
         ]);
});

it('can bulk create student profit', function(){
    $requests = [
        [
            'student_id' => 1,
            'profit_id' => 1,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 45000
        ],
        [
            'student_id' => 2,
            'profit_id' => 2,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 75000
        ],
        [
            'student_id' => 3,
            'profit_id' => 3,
            'date' => Carbon::now()->format('Y-m-d'),
            'amount' => 120000
        ]
    ];

    $this->postJson('api/v1/profit-student', ['profit_students' => json_encode($requests)])
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit Students has been stored'
         ]);
});

it ('can show profit student', function(){
    $this->getJson('api/v1/profit-student/1')
         ->assertStatus(200)
         ->assertJsonStructure(['code_status', 'msg_status', 'data']);
});

it ('can update profit student', function(){
    $request = [
        'student_id' => 1,
        'profit_id' => 1,
        'date' => Carbon::now()->format('Y-m-d'),
        'amount' => 40000
    ];

    $this->putJson('api/v1/profit-student/1', $request)
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit Student has been updated'
         ]);
    
});

it ('can delete profit student', function(){
    $this->deleteJson('api/v1/profit-student/1?date=' . Carbon::now()->format('Y-m-d'))
         ->assertStatus(200)
         ->assertExactJson([
             'code_status' => 200,
             'msg_status' => 'Profit Student has been deleted'
         ]);
});