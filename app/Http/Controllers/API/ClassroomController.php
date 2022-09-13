<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest\StoreClassroomRequest;
use App\Http\Requests\ClassroomRequest\UpdateClassroomRequest;
use App\Libs\Response\ResponseJSON;
use Illuminate\Support\Facades\Redis;
use App\Models\Classroom;
use App\Repositories\ClassroomRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ClassroomController extends Controller
{
    private $classroomRepo;

    public function __construct(ClassroomRepository $classroomRepo)
    {
        $this->classroomRepo = $classroomRepo;

        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index() : JsonResponse
    {
        $this->authorize('viewAny', Classroom::class);

        if (!Redis::get('classroom.lists')) {
            Redis::set('classroom.lists', json_encode($this->classroomRepo->getClassrooms()));
        }

        $classrooms = json_decode(Redis::get('classroom.lists'));

        return ResponseJSON::successWithData('Classrooms has been loaded', $classrooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClassroomRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreClassroomRequest $request) : JsonResponse
    {
        $this->authorize('create', Classroom::class);

        $this->classroomRepo->storeClassroom($request->validated());

        return ResponseJSON::success('Classroom has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(int $id) : JsonResponse
    {
        $this->authorize('view', Classroom::findOrFail($id));

        return ResponseJSON::successWithData('Classroom has been loaded', $this->classroomRepo->getClassroom($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClassroomRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateClassroomRequest $request, int $id) : JsonResponse
    {
        $this->authorize('update', Classroom::findOrFail($id));

        $this->classroomRepo->updateClassroom($request->validated(), $id);

        return ResponseJSON::success('Classroom has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id) : JsonResponse
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

