<?php

namespace App\Repositories;

use JsonSerializable;

interface ParentIncomeRespository {
    public function getParentIncomes () : JsonSerializable;
    public function storeParentIncome (array $requests) : bool;
    public function getParentIncome (int $id) : JsonSerializable;
    public function updateParentIncome (array $requests, int $id) : bool;
    public function destroyParentIncome (int $id) : bool;
}