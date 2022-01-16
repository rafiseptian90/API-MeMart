<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profit\StoreProfitRequest;
use App\Libs\Response\ResponseJSON;
use App\Repositories\EloquentProfitRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    protected $profitRepo;

    public function __construct(EloquentProfitRepository $profitRepo)
    {
        $this->profitRepo = $profitRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $profits = $this->profitRepo->getProfits();

        return ResponseJSON::successWithData('Profits has been loaded', $profits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Profit\StoreProfitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProfitRequest $request): JsonResponse
    {
        $requests = $request->all();
        $request->has('students') 
                ? $requests['students'] = json_decode($request->students) 
                : '';

        try {
            $this->profitRepo->storeProfit($requests);

            return ResponseJSON::success('New profit has been added');
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
        $profit = $this->profitRepo->getProfit($id);

        return ResponseJSON::successWithData('Profit has been loaded', $profit);
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
        $requests = $request->all();
        $request->has('students') 
                ? $requests['students'] = json_decode($request->students) 
                : '';

        try {
            $this->profitRepo->updateProfit($requests, $id);

            return ResponseJSON::success('Profit has been updated');
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
        $this->profitRepo->destroyProfit($id);

        return ResponseJSON::success('Profit has been deleted');
    }
}
