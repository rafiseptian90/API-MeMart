<?php

namespace App\Repositories;

use App\Http\Resources\ParentIncomeResource;
use App\Models\ParentIncome;
use JsonSerializable;
use Exception;

interface ParentIncomeRespository {
    public function getParentIncomes () : JsonSerializable;
    public function storeParentIncome (array $requests) : bool;
    public function getParentIncome (int $id) : JsonSerializable;
    public function updateParentIncome (array $requests, int $id) : bool;
    public function destroyParentIncome (int $id) : bool;
}

class EloquentParentIncomeRepository implements ParentIncomeRespository {

    public function getParentIncomes(): JsonSerializable
    {  
       $incomes = ParentIncomeResource::collection(
           ParentIncome::latest()->get()
       );

       return $incomes;
    }

    public function storeParentIncome(array $requests): bool
    {
        $income = ParentIncome::create($requests);

        if (!$income) {
            return false;
        }

        return true;
    }

    public function getParentIncome(int $id): JsonSerializable
    {
        $income = ParentIncomeResource::make(
            ParentIncome::with(['students' => function($student) {
                            $student->with(['profile']);
                        }])
                        ->findOrFail($id)
        );

        return $income;
    }

    public function updateParentIncome(array $requests, int $id): bool
    {
        $income = ParentIncome::findOrFail($id);
        $income->update($requests);

        if (!$income) {
            return false;
        }

        return true;
    }

    public function destroyParentIncome(int $id): bool
    {
        $income = ParentIncome::findOrFail($id);
        
        if (!$income->students->isEmpty()) {
            throw new Exception("Cannot delete this parent income because they have a student data");   
        }

        $income->delete();

        return true;
    }
}