<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OtherCriteria\StoreOtherCriteriaRequest;
use App\Http\Requests\OtherCriteria\UpdateOtherCriteriaRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\OtherCriteria;
use App\Repositories\EloquentOtherCriteriaRepository;
use Illuminate\Http\Request;

class OtherCriteriaController extends Controller
{
    protected $otherCriteriaRepo;

    public function __construct(EloquentOtherCriteriaRepository $otherCriteriaRepo)
    {
        $this->otherCriteriaRepo = $otherCriteriaRepo;   

        $this->middleware('auth:sanctum');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', OtherCriteria::class);

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
        $this->authorize('create', OtherCriteria::class);

        $requests = $request->validated();

        $this->otherCriteriaRepo->storeOtherCriteria($requests);

        return ResponseJSON::success('New Other Criteria has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', OtherCriteria::findOrFail($id));

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
        $this->authorize('update', OtherCriteria::findOrFail($id));

        $requests = $request->validated();

        $this->otherCriteriaRepo->updateOtherCriteria($requests, $id);

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
        $this->authorize('delete', OtherCriteria::findOrFail($id));
        
        try {
           $this->otherCriteriaRepo->destroyOtherCriteria($id);

            return ResponseJSON::success('Other Criteria has been deleted');
        } catch (\Exception $ex) {
            return ResponseJSON::unprocessableEntity($ex->getMessage());
        }
    }
}
