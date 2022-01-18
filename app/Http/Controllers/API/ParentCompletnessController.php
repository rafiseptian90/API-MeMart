<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParentCompletness\StoreParentCompletnessRequest;
use App\Http\Requests\ParentCompletness\UpdateParentCompletnessRequest;
use App\Libs\Response\ResponseJSON;
use App\Repositories\EloquentParentCompletnessRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParentCompletnessController extends Controller
{
    protected $parentCompletnessRepo;

    public function __construct(EloquentParentCompletnessRepository $parentCompletnessRepo)
    {
        $this->parentCompletnessRepo = $parentCompletnessRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $parents = $this->parentCompletnessRepo->getParentCompletnesses();

        return ResponseJSON::successWithData('Parent Completnesses has been loaded', $parents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ParentCompletness\StoreParentCompletnessRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParentCompletnessRequest $request): JsonResponse
    {
        $requests = $request->validated();

        $this->parentCompletnessRepo->storeParentCompletness($requests);

        return ResponseJSON::success('New Parent Completness has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parent = $this->parentCompletnessRepo->getParentCompletness($id);

        return ResponseJSON::successWithData('Parent Completness has been loaded', $parent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ParentCompletness\UpdateParentCompletnessRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParentCompletnessRequest $request, $id)
    {
        $requests = $request->validated();

        $this->parentCompletnessRepo->updateParentCompletness($requests, $id);

        return ResponseJSON::success('Parent Completness has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->parentCompletnessRepo->destroyParentCompletness($id);

        if (!$res) {
            return ResponseJSON::badRequest('This action cannot be executed for some reason');
        }

        return ResponseJSON::success('Parent Completness has been deleted');
    }
}
