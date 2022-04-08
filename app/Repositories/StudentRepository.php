<?php

namespace App\Repositories;

use App\Http\Resources\StudentResource;
use App\Models\Profile;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use JsonSerializable;

class StudentRepository {
    /**
     * @return JsonSerializable
     */
    public function getStudents(): JsonSerializable
    {
        return StudentResource::collection(
            Student::with(['classroom', 'profile', 'parent_completness', 'parent_income', 'other_criteria'])
                ->latest()
                ->get()
        )->groupBy('classroom.name');
    }

    /**
     * @param array $requests
     * @return mixed
     */
    public function storeStudent(array $requests)
    {
        return DB::transaction(function() use($requests){
            $user = User::create((array) $requests['userRequests']);
            $requests['profileRequests']['user_id'] = $user->id;
            $profile = Profile::create((array) $requests['profileRequests']);
            $requests['studentRequests']['profile_id'] = $profile->id;

            Student::create((array) $requests['studentRequests']);
        });
    }

    /**
     * @param int $id
     * @return JsonSerializable
     */
    public function getStudent(int $id): JsonSerializable
    {
        return StudentResource::make(
            Student::with(['classroom', 'parent_completness', 'parent_income', 'other_criteria', 'profile', 'profits'])
                ->findOrFail($id)
        );
    }

    /**
     * @param array $requests
     * @param int $id
     * @return mixed
     */
    public function updateStudent(array $requests, int $id)
    {
        $student = Student::findOrFail($id);
        $profile = Profile::whereHas('student', function($query) use($student){
                                $query->whereId($student->id);
                            })
                            ->first();

        return DB::transaction(function() use($requests, $profile, $student) {
            // update student profile
            $profile->user()->update((array) $requests['userRequests']);
            $profile->update((array) $requests['profileRequests']);

            // update student
            $student->update((array) $requests['studentRequests']);
        });
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroyStudent(int $id)
    {
        $student = Student::findOrFail($id);

        $student->profits()->detach();
        return $student->delete();
    }
}
