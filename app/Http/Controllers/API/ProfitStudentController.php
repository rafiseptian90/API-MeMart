<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Libs\Response\ResponseJSON;
use App\Repositories\EloquentProfitStudentRepository;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfitStudentController extends Controller
{
    private $profitStudentRepo;

    public function __construct(EloquentProfitStudentRepository $profitStudentRepo)
    {
        $this->profitStudentRepo = $profitStudentRepo;

        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->tokenCan('browse_profit_student')) {
            return Response::deny('Access Forbidden');
        }
        
        $studentProfits = $this->profitStudentRepo->getProfitStudents();

        return ResponseJSON::successWithData('Profit Students has been loaded', $studentProfits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('create_profit_student')) {
            return Response::deny('Action Denied');
        }

        $requests = json_decode($request->profit_students);

        $this->profitStudentRepo->storeProfitStudent($requests);

        return ResponseJSON::success('Profit Students has been stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->tokenCan('read_profit_student')) {
            return Response::deny('Access Forbidden');
        }

        $profitStudent = $this->profitStudentRepo->getProfitStudent($id);

        return ResponseJSON::successWithData('Student Profit has been loaded', $profitStudent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('update_profit_student')) {
            return Response::deny('Action Denied');
        }

        $this->profitStudentRepo->updateProfitStudent($request->only(['student_id', 'profit_id', 'date', 'amount']), $id);

        return ResponseJSON::success('Profit Student has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->tokenCan('delete_profit_student')) {
            return Response::deny('Action Denied');
        }

        $this->profitStudentRepo->destroyProfitStudent($id);

        return ResponseJSON::success('Profit Student has been deleted');
    }
}
