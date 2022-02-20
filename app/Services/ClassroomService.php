<?php

namespace App\Services;

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use Exception;
use JsonSerializable;

class ClassroomService {
    /**
     * @return JsonSerializable
     */
    public function getClassrooms() : JsonSerializable
    {
        return ClassroomResource::collection(Classroom::latest()->get());
    }

    /**
     * @param array $requests
     * @return mixed
     */
    public function storeClassroom(array $requests)
    {
        return Classroom::create($requests);
    }

    /**
     * @param $classroom_id
     * @return JsonSerializable
     */
    public function getClassroom($classroom_id) : JsonSerializable
    {
        return ClassroomResource::make(Classroom::with(['students' => function($student) {
                                    $student->with(['profile']);
                                }])
                                ->findOrFail($classroom_id));
    }

    /**
     * @param array $requests
     * @param int $classroom_id
     * @return mixed
     */
    public function updateClassroom(array $requests, int $classroom_id)
    {
        return Classroom::findOrFail($classroom_id)->update($requests);
    }

    /**
     * @params int $classroom_id
     * @throws Exception
     */
    public function destroyClassroom(int $classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);

        if (!$classroom->students->isEmpty()) {
            throw new Exception("Cannot delete this classroom because they have a student data");
        }

       return $classroom->delete();
    }
}
