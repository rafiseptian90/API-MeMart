<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Libs\Response\ResponseJSON;
use App\Repositories\EloquentStudentRepository;
use Illuminate\Support\Arr;

class StudentController extends Controller
{
    protected $studentRepo;

    public function __construct(EloquentStudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $requests = $request->all();

        $studentRequests = Arr::except($requests, [
                                ['name','card_number','card_type','phone_number','gender','address','photo']
                           ]);

        $profileRequests = Arr::only($requests, [
                                ['name','card_number','card_type','phone_number','gender','address','photo']
                           ]);

        $userRequests = [
            'username' => $requests['card_number'],
            'password' => bcrypt(substr($requests['phone_number'], -5))
        ];

        $requests = [
            'studentRequests' => $studentRequests,
            'profileRequests' => $profileRequests,
            'userRequests' => $userRequests
        ];

        try {
            $this->studentRepo->storeStudent($requests);

            return ResponseJSON::success('New Student has been added');
        } catch (\Exception $e) {
            return ResponseJSON::internalServerError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $requests = $request->all();

        $studentRequests = Arr::except($requests, [
                                ['name','card_number','card_type','phone_number','gender','address','photo']
                           ]);

        $profileRequests = Arr::only($requests, [
                                ['name','card_number','card_type','phone_number','gender','address','photo']
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
        $this->studentRepo->destroyStudent($id);
        
        return ResponseJSON::success('Student has been deleted');
    }
}
