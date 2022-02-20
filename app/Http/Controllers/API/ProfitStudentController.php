<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Libs\Response\ResponseJSON;
use App\Repositories\EloquentProfitStudentRepository;
use App\Services\ProfitStudentService;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfitStudentController extends Controller
{
    private $profitStudentService;

    public function __construct(ProfitStudentService $profitStudentService)
    {
        $this->profitStudentService = $profitStudentService;

        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        if (!auth()->user()->tokenCan('browse_profit_student')) {
            return ResponseJSON::forbidden('Access Forbidden');
        }

        return ResponseJSON::successWithData('Profit Students has been loaded', $this->profitStudentService->getProfitStudents());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'profit_students' => 'required'
        ]);

        if (!auth()->user()->tokenCan('create_profit_student')) {
            return ResponseJSON::forbidden('Action Denied');
        }

        $requests = json_decode(json_encode($request->profit_students));

        $this->profitStudentService->storeProfitStudent($requests);

        return ResponseJSON::success('Profit Students has been stored');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        if (!auth()->user()->tokenCan('read_profit_student')) {
            return ResponseJSON::forbidden('Access Forbidden');
        }

        return ResponseJSON::successWithData('Student Profit has been loaded', $this->profitStudentService->getProfitStudent($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'profit_id' => 'required',
            'date' => 'required|date|date_format:Y-m-d',
            'amount' => 'required'
        ]);

        if (!auth()->user()->tokenCan('update_profit_student')) {
            return ResponseJSON::forbidden('Action Denied');
        }

        $this->profitStudentService->updateProfitStudent($request->only(['profit_id', 'date', 'amount']), $id);

        return ResponseJSON::success('Profit Student has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if (!auth()->user()->tokenCan('delete_profit_student')) {
            return ResponseJSON::forbidden('Action Denied');
        }

        $this->profitStudentService->destroyProfitStudent($id);

        return ResponseJSON::success('Profit Student has been deleted');
    }
}
