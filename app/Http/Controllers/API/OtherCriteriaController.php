<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OtherCriteria\StoreOtherCriteriaRequest;
use App\Http\Requests\OtherCriteria\UpdateOtherCriteriaRequest;
use App\Libs\Response\ResponseJSON;
use App\Repositories\EloquentOtherCriteriaRepository;
use Illuminate\Http\Request;

class OtherCriteriaController extends Controller
{
    protected $otherCriteriaRepo;

    public function __construct(EloquentOtherCriteriaRepository $otherCriteriaRepo)
    {
        $this->otherCriteriaRepo = $otherCriteriaRepo;   
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criterias = $this->otherCriteriaRepo->getOtherCriterias();

        return ResponseJSON::successWithData('Other Criterias has been loaded', $criterias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\OtherCriteria\StoreOtherCriteriaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOtherCriteriaRequest $request)
    {
        $requests = $request->validated();

        $res = $this->otherCriteriaRepo->storeOtherCriteria($requests);

        if (!$res) {
            return ResponseJSON::internalServerError('Internal Server Error');
        }

        return ResponseJSON::success('Other Criteria has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $criteria = $this->otherCriteriaRepo->getOtherCriteria($id);

        return ResponseJSON::successWithData('Other Criteria has been loaded', $criteria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\OtherCriteria\UpdateOtherCriteriaRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOtherCriteriaRequest $request, $id)
    {
        $requests = $request->validated();

        $res = $this->otherCriteriaRepo->updateOtherCriteria($requests, $id);

        if (!$res) {
            return ResponseJSON::internalServerError('Internal Server Error');
        }

        return ResponseJSON::success('Other Criteria has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->otherCriteriaRepo->destroyOtherCriteria($id);

        if (!$res) {
            return ResponseJSON::internalServerError('Internal Server Error');
        }

        return ResponseJSON::success('Other Criteria has been deleted');
    }
}
