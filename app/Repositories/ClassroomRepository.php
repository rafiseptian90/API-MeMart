<?php

namespace App\Repositories;

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use JsonSerializable;
use Exception;

interface ClassroomRepository {
    public function getClassrooms () : JsonSerializable ;
    public function storeClassroom (array $requests) : bool;
    public function getClassroom (int $classroom_id) : JsonSerializable;
    public function updateClassroom (array $requests, int $classroom_id) : bool;
    public function destroyClassroom (int $classroom_id) : bool;
}

class EloquentClassroomRepository implements ClassroomRepository {
    public function getClassrooms() : JsonSerializable
    {
        $classrooms = ClassroomResource::collection(Classroom::latest()->get());

        return $classrooms;
    }

    public function storeClassroom(array $requests) : bool
    {
        $classroom = Classroom::create($requests);

        if (!$classroom) {
            return false;
        }

        return true;
    }

    public function getClassroom($classroom_id) : JsonSerializable
    {
        $classroom = ClassroomResource::make(Classroom::with(['students' => function($student) {
                                        $student->with(['profile']);
                                    }])
                                    ->findOrFail($classroom_id));

        return $classroom;
    }

    public function updateClassroom(array $requests, int $classroom_id) : bool
    {
        $classroom = Classroom::findOrFail($classroom_id);
        $res = $classroom->update($requests);

        if (!$res) {
            return false;
        }

        return true;
    }

    public function destroyClassroom(int $classroom_id) : bool
    {
        $classroom = Classroom::findOrFail($classroom_id);

        if (!$classroom->students->isEmpty()) {
            throw new Exception("Cannot delete this classroom because they have a student data");
        }

        $classroom->delete();

        return true;
    }
}