<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParentIncome\StoreParentIncomeRequest;
use App\Libs\Response\ResponseJSON;
use App\Repositories\EloquentParentIncomeRepository;
use Illuminate\Http\Request;

class ParentIncomeController extends Controller
{
    protected $parentIncomeRepo;

    public function __construct(EloquentParentIncomeRepository $parentIncomeRepo)
    {
        $this->parentIncomeRepo = $parentIncomeRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes = $this->parentIncomeRepo->getParentIncomes();

        return ResponseJSON::successWithData('Parent Incomes has been loaded', $incomes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\ParentIncome\StoreParentIncomeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParentIncomeRequest $request)
    {
        $requests = $request->validated();

        $res = $this->parentIncomeRepo->storeParentIncome($requests);

        if (!$res) {
            return ResponseJSON::internalServerError('Internal Server Error');
        }

        return ResponseJSON::success('New Parent Income has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $income = $this->parentIncomeRepo->getParentIncome($id);

        return ResponseJSON::successWithData('Parent Income has been loaded', $income);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\ParentIncome\UpdateParentIncomeRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requests = $request->validated();

        $res = $this->parentIncomeRepo->updateParentIncome($requests, $id);

        if (!$res) {
            return ResponseJSON::internalServerError('Internal Server Error');
        }

        return ResponseJSON::success('Parent Income has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->parentIncomeRepo->destroyParentIncome($id);

        if (!$res) {
            return ResponseJSON::internalServerError('Internal Server Error');
        }

        return ResponseJSON::success('Parent Income has been deleted');
    }
}
