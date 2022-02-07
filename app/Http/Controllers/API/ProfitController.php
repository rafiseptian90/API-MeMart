<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profit\StoreProfitRequest;
use App\Http\Requests\Profit\UpdateProfitRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\Profit;
use App\Repositories\EloquentProfitRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    protected $profitRepo;

    public function __construct(EloquentProfitRepository $profitRepo)
    {
        $this->profitRepo = $profitRepo;

        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Profit::class);

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
        $this->authorize('create', Profit::class);

        $requests = $request->all();

        try {
            $this->profitRepo->storeProfit($requests);

            return ResponseJSON::success('New Profit has been added');
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
        $this->authorize('view', Profit::find($id));

        $profit = $this->profitRepo->getProfit($id);

        return ResponseJSON::successWithData('Profit has been loaded', $profit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Profit\UpdateProfitRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfitRequest $request, $id)
    {
        $this->authorize('update', Profit::find($id));

        $requests = $request->all();

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
        $this->authorize('delete', Profit::find($id));

        $this->profitRepo->destroyProfit($id);

        return ResponseJSON::success('Profit has been deleted');
    }
}
