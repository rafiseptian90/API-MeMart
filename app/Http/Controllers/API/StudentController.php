<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\Student;
use App\Repositories\EloquentStudentRepository;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Student::class);

        $students = $this->studentRepo->getStudents();

        return ResponseJSON::successWithData('Students has been loaded', $students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Student\StoreStudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Student::findOrFail($id));

        $student = $this->studentRepo->getStudent($id);

        return ResponseJSON::successWithData('Student has been loaded', $student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Student\UpdateStudentRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, $id)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Student::findOrFail($id));

        $this->studentRepo->destroyStudent($id);
        
        return ResponseJSON::success('Student has been deleted');
    }
}
