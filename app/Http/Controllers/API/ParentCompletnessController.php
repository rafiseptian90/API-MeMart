<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParentCompletness\StoreParentCompletnessRequest;
use App\Http\Requests\ParentCompletness\UpdateParentCompletnessRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\ParentCompletness;
use App\Repositories\ParentCompletnessRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ParentCompletnessController extends Controller
{
    private $parentCompletnessRepo;

    public function __construct(ParentCompletnessRepository $parentCompletnessRepo)
    {
        $this->parentCompletnessRepo = $parentCompletnessRepo;

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
        $this->authorize('viewAny', ParentCompletness::class);

        return ResponseJSON::successWithData('Parent Completnesses has been loaded', $this->parentCompletnessRepo->getParentCompletnesses());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParentCompletnessRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreParentCompletnessRequest $request): JsonResponse
    {
        $this->authorize('create', ParentCompletness::class);

        $this->parentCompletnessRepo->storeParentCompletness($request->validated());

        return ResponseJSON::success('New Parent Completness has been added');
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
        $this->authorize('view', ParentCompletness::findOrFail($id));

        return ResponseJSON::successWithData('Parent Completness has been loaded', $this->parentCompletnessRepo->getParentCompletness($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateParentCompletnessRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateParentCompletnessRequest $request, int $id): JsonResponse
    {
        $this->authorize('update', ParentCompletness::findOrFail($id));

        $this->parentCompletnessRepo->updateParentCompletness($request->validated(), $id);

        return ResponseJSON::success('Parent Completness has been updated');
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
        $this->authorize('delete', ParentCompletness::findOrFail($id));

        try {
            $this->parentCompletnessRepo->destroyParentCompletness($id);
            return ResponseJSON::success('Parent Completness has been deleted');
        } catch (\Exception $ex) {
            return ResponseJSON::unprocessableEntity($ex->getMessage());
        }
    }
}
