<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParentIncome\StoreParentIncomeRequest;
use App\Http\Requests\ParentIncome\UpdateParentIncomeRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\ParentIncome;
use App\Repositories\ParentIncomeRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ParentIncomeController extends Controller
{
    private $parentIncomeRepo;

    public function __construct(ParentIncomeRepository $parentIncomeRepo)
    {
        $this->parentIncomeRepo = $parentIncomeRepo;

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
        $this->authorize('viewAny', ParentIncome::class);

        return ResponseJSON::successWithData('Parent Incomes has been loaded', $this->parentIncomeRepo->getParentIncomes());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParentIncomeRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreParentIncomeRequest $request): JsonResponse
    {
        $this->authorize('create', ParentIncome::class);

        $this->parentIncomeRepo->storeParentIncome($request->validated());

        return ResponseJSON::success('New Parent Income has been added');
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
        $this->authorize('view', ParentIncome::findOrFail($id));

        return ResponseJSON::successWithData('Parent Income has been loaded', $this->parentIncomeRepo->getParentIncome($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateParentIncomeRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateParentIncomeRequest $request, int $id): JsonResponse
    {
        $this->authorize('update', ParentIncome::findOrFail($id));

        $this->parentIncomeRepo->updateParentIncome($request->validated(), $id);

        return ResponseJSON::success('Parent Income has been updated');
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
        $this->authorize('delete', ParentIncome::findOrFail($id));

        try {
            $this->parentIncomeRepo->destroyParentIncome($id);
            return ResponseJSON::success('Parent Income has been deleted');
        } catch (\Exception $ex) {
            return ResponseJSON::unprocessableEntity($ex->getMessage());
        }
    }
}
