<?php

namespace App\Repositories;

use App\Http\Resources\StudentResource;
use App\Models\Profile;
use App\Models\Student;
use App\Models\User;
use JsonSerializable;
use Exception;
use Illuminate\Support\Facades\DB;

interface StudentRepository {
    public function getStudents(): JsonSerializable;
    public function storeStudent(array $requests): bool;
    public function getStudent(int $id): JsonSerializable;
    public function updateStudent(array $requests, int $id): bool;
    public function destroyStudent(int $id): bool;
}

class EloquentStudentRepository implements StudentRepository {

    public function getStudents(): JsonSerializable
    {
        $students = StudentResource::collection(
            Student::with(['classroom', 'profile', 'parent_completness', 'parent_income', 'other_criteria'])
                    ->latest()
                    ->get()
        )
        ->groupBy('classroom.name');

        return $students;
    }

    public function storeStudent(array $requests): bool
    {
        DB::transaction(function() use($requests){
            $user = User::create((array) $requests['userRequests']);
            $requests['profileRequests']['user_id'] = $user->id;
            $profile = Profile::create((array) $requests['profileRequests']);
            $requests['studentRequests']['profile_id'] = $profile->id;
            
            Student::create((array) $requests['studentRequests']);
        });

        return true;
    }

    public function getStudent(int $id): JsonSerializable
    {
        $student = StudentResource::make(
                        Student::with(['classroom', 'parent_completness', 'parent_income', 'other_criteria', 'profile', 'profits'])
                                ->findOrFail($id)
                    );
            
        return $student;
    }

    public function updateStudent(array $requests, int $id): bool
    {
        $student = Student::findOrFail($id);

        $profile = Profile::whereHas('student', function($query) use($student){
                             $query->whereId($student->id);
                          })
                          ->first();
                          
        DB::transaction(function() use($requests, $profile, $student) {
            // update student profile
            $profile->user()->update((array) $requests['userRequests']);
            $profile->update((array) $requests['profileRequests']);

            // update student
            $student->update((array) $requests['studentRequests']);
        });

        return true;
    }

    public function destroyStudent(int $id): bool
    {
        $student = Student::findOrFail($id);
        $student->profits()->detach();
        $student->delete();

        return true;
    }
}