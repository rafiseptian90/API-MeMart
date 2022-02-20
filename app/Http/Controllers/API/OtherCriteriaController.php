<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OtherCriteria\StoreOtherCriteriaRequest;
use App\Http\Requests\OtherCriteria\UpdateOtherCriteriaRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\OtherCriteria;
use App\Services\OtherCriteriaService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class OtherCriteriaController extends Controller
{
    private $otherCriteriaService;

    public function __construct(OtherCriteriaService $otherCriteriaService)
    {
        $this->otherCriteriaService = $otherCriteriaService;

        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', OtherCriteria::class);

        return ResponseJSON::successWithData('Other Criterias has been loaded', $this->otherCriteriaService->getOtherCriterias());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOtherCriteriaRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreOtherCriteriaRequest $request): JsonResponse
    {
        $this->authorize('create', OtherCriteria::class);

        $this->otherCriteriaService->storeOtherCriteria($request->validated());

        return ResponseJSON::success('New Other Criteria has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(int $id): JsonResponse
    {
        $this->authorize('view', OtherCriteria::findOrFail($id));

        return ResponseJSON::successWithData('Other Criteria has been loaded', $this->otherCriteriaService->getOtherCriteria($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOtherCriteriaRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateOtherCriteriaRequest $request, int $id): JsonResponse
    {
        $this->authorize('update', OtherCriteria::findOrFail($id));

        $this->otherCriteriaService->updateOtherCriteria($request->validated(), $id);

        return ResponseJSON::success('Other Criteria has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->authorize('delete', OtherCriteria::findOrFail($id));

        try {
           $this->otherCriteriaService->destroyOtherCriteria($id);
            return ResponseJSON::success('Other Criteria has been deleted');
        } catch (\Exception $ex) {
            return ResponseJSON::unprocessableEntity($ex->getMessage());
        }
    }
}
