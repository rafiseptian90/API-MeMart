<?php

namespace App\Repositories;

use App\Http\Resources\OtherCriteriaResource;
use App\Models\OtherCriteria;
use JsonSerializable;

interface OtherCriteriaRepository {
    public function getOtherCriterias () : JsonSerializable;
    public function storeOtherCriteria (array $requests) : bool;
    public function getOtherCriteria (int $id) : JsonSerializable;
    public function updateOtherCriteria (array $requests, int $id) : bool;
    public function destroyOtherCriteria (int $id) : bool; 
}

class EloquentOtherCriteriaRepository implements OtherCriteriaRepository {

    public function getOtherCriterias(): JsonSerializable
    {
        $criterias = OtherCriteriaResource::collection(OtherCriteria::latest()->get());

        return $criterias;
    }

    public function storeOtherCriteria(array $requests): bool
    {
        $criteria = OtherCriteria::create($requests);

        if (!$criteria) {
            return false;
        }

        return true;
    }

    public function getOtherCriteria(int $id): JsonSerializable
    {
        $criteria = OtherCriteriaResource::make(
            OtherCriteria::with(['students'])
                         ->findOrFail($id)
        );

        return $criteria;
    }

    public function updateOtherCriteria(array $requests, int $id): bool
    {
        $criteria = OtherCriteria::findOrFail($id);
        $res = $criteria->update($requests);

        if (!$res) {
            return false;
        }

        return true;
    }

    public function destroyOtherCriteria(int $id): bool
    {
        $criteria = OtherCriteria::findOrFail($id);

        if (!$criteria->students->isEmpty()) {
            return false;
        }

        $criteria->delete();

        return true;
    }
}