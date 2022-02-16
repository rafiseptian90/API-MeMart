<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest\StoreClassroomRequest;
use App\Http\Requests\ClassroomRequest\UpdateClassroomRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\Classroom;
use App\Repositories\EloquentClassroomRepository;
use Illuminate\Http\JsonResponse;

class ClassroomController extends Controller
{
    protected $classroomRepo;

    public function __construct(EloquentClassroomRepository $classroomRepo)
    {
        $this->classroomRepo = $classroomRepo;

        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : JsonResponse
    {
        $this->authorize('viewAny', Classroom::class);

        $clasrooms = $this->classroomRepo->getClassrooms();

        return ResponseJSON::successWithData('Classrooms has been loaded', $clasrooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClassroomRequest\StoreClassroomRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClassroomRequest $request) : JsonResponse
    {
        $this->authorize('create', Classroom::class);

        $requests = $request->validated();

        $this->classroomRepo->storeClassroom($requests);

        return ResponseJSON::success('Classroom has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) : JsonResponse
    {
        $this->authorize('view', Classroom::findOrFail($id));

        $classroom = $this->classroomRepo->getClassroom($id);

        return ResponseJSON::successWithData('Classroom has been loaded', $classroom);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ClassroomRequest\UpdateClassroomRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassroomRequest $request, $id) : JsonResponse
    {
        $this->authorize('update', Classroom::findOrFail($id));

        $requests = $request->validated();

        $this->classroomRepo->updateClassroom($requests, $id);

        return ResponseJSON::success('Classroom has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : JsonResponse
    {
        $this->authorize('delete', Classroom::findOrFail($id));

        try {
            $this->classroomRepo->destroyClassroom($id);

            return ResponseJSON::success('Classroom has been deleted');
        } catch (\Exception $ex) {
            return ResponseJSON::unprocessableEntity($ex->getMessage());
        }
    }
}
