<?php

namespace App\Repositories;

use App\Http\Resources\ParentIncomeResource;
use App\Models\ParentIncome;
use JsonSerializable;
use Exception;

class ParentIncomeRepository {
    /**
     * @return JsonSerializable
     */
    public function getParentIncomes (): JsonSerializable
    {
        return ParentIncomeResource::collection(
            ParentIncome::latest()->get()
        );
    }

    /**
     * @param array $requests
     * @return mixed
     */
    public function storeParentIncome(array $requests)
    {
        return ParentIncome::create($requests);
    }

    /**
     * @param int $id
     * @return JsonSerializable
     */
    public function getParentIncome(int $id): JsonSerializable
    {
        return ParentIncomeResource::make(
            ParentIncome::with(['students' => function($student) {
                            $student->with(['profile']);
                        }])
                        ->findOrFail($id)
        );
    }

    /**
     * @param array $requests
     * @param int $id
     * @return mixed
     */
    public function updateParentIncome(array $requests, int $id)
    {
        return ParentIncome::findOrFail($id)->update($requests);
    }

    /**
     * @param int $id
     * @throws Exception
     * @return mixed
     */
    public function destroyParentIncome(int $id)
    {
        $income = ParentIncome::findOrFail($id);

        if (!$income->students->isEmpty()) {
            throw new Exception("Cannot delete this parent income because they have a student data");
        }

        return $income->delete();
    }
}
