<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\Student;
use App\Repositories\EloquentStudentRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class StudentController extends Controller
{
    protected $studentRepo;

    public function __construct(EloquentStudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;

        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Student::class);

        $students = $this->studentRepo->getStudents();

        return ResponseJSON::successWithData('Students has been loaded', (array) $students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStudentRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        $this->authorize('create', Student::class);

        $requests = $request->all();

        $studentRequests = Arr::except($requests, [
                                'name','card_number','card_type','phone_number','gender','address','photo'
                           ]);

        $profileRequests = Arr::only($requests, [
                                'name','card_number','card_type','phone_number','gender','address','photo'
                           ]);

        $userRequests = [
            'username' => $requests['card_number'],
            'password' => bcrypt(substr($requests['phone_number'], -5)),
            'role_id' => 3
        ];

        $requests = [
            'studentRequests' => $studentRequests,
            'profileRequests' => $profileRequests,
            'userRequests' => $userRequests
        ];

        $this->studentRepo->storeStudent($requests);

        return ResponseJSON::success('New Student has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(int $id): JsonResponse
    {
        $this->authorize('view', Student::findOrFail($id));

        $student = $this->studentRepo->getStudent($id);

        return ResponseJSON::successWithData('Student has been loaded', (array) $student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStudentRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateStudentRequest $request, $id): JsonResponse
    {
        $this->authorize('update', Student::findOrFail($id));

        $requests = $request->all();

        $studentRequests = Arr::except($requests, [
                                'name','card_number','card_type','phone_number','gender','address','photo'
                           ]);

        $profileRequests = Arr::only($requests, [
                                'name','card_number','card_type','phone_number','gender','address','photo'
                           ]);

        $userRequests = [
            'username' => $requests['card_number']
        ];

        $requests = [
            'studentRequests' => $studentRequests,
            'profileRequests' => $profileRequests,
            'userRequests' => $userRequests
        ];

        try {
            $this->studentRepo->updateStudent($requests, $id);

            return ResponseJSON::success('Student has been updated');
        } catch (\Exception $e) {
            return ResponseJSON::internalServerError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        $this->authorize('delete', Student::findOrFail($id));

        $this->studentRepo->destroyStudent($id);

        return ResponseJSON::success('Student has been deleted');
    }
}
