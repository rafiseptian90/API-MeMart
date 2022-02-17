<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest\StoreClassroomRequest;
use App\Http\Requests\ClassroomRequest\UpdateClassroomRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ClassroomController extends Controller
{
    private $classroomService;

    public function __construct(ClassroomService $classroomService)
    {
        $this->classroomService = $classroomService;

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

        return ResponseJSON::successWithData('Classrooms has been loaded', $this->classroomService->getClassrooms());
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

        $this->classroomService->storeClassroom($request->validated());

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

        return ResponseJSON::successWithData('Classroom has been loaded', $this->classroomService->getClassroom($id));
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

        $this->classroomService->updateClassroom($request->validated(), $id);

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
            $this->classroomService->destroyClassroom($id);
            return ResponseJSON::success('Classroom has been deleted');
        } catch (\Exception $ex) {
            return ResponseJSON::unprocessableEntity($ex->getMessage());
        }
    }
}
