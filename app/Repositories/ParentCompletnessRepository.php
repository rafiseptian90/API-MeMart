<?php

namespace App\Repositories;

use App\Http\Resources\ParentCompletnessResource;
use App\Models\ParentCompletness;
use JsonSerializable;

interface ParentCompletnessRepository {
    public function getParentCompletnesses(): JsonSerializable;
    public function storeParentCompletness(array $requests): bool;
    public function getParentCompletness(int $id): JsonSerializable;
    public function updateParentCompletness(array $requests, int $id): bool;
    public function destroyParentCompletness(int $id): bool;
}

class EloquentParentCompletnessRepository implements ParentCompletnessRepository {

    public function getParentCompletnesses(): JsonSerializable
    {
        $parents = ParentCompletnessResource::collection(
            ParentCompletness::latest()->get()
        );

        return $parents;
    }

    public function storeParentCompletness(array $requests): bool
    {
        $res = ParentCompletness::create($requests);

        if (!$res) {
            return false;
        }

        return true;
    }

    public function getParentCompletness(int $id): JsonSerializable
    {
        $parent = ParentCompletnessResource::make(
            ParentCompletness::with(['students'])
                             ->findOrFail($id)
        );

        return $parent;
    }

    public function updateParentCompletness(array $requests, int $id): bool
    {
        $parent = ParentCompletness::findOrFail($id);
        $res = $parent->update($requests);

        if (!$res) { 
            return false;
        }

        return true;
    }

    public function destroyParentCompletness(int $id): bool
    {
        $parent = ParentCompletness::findOrFail($id);

        if (!$parent->students->isEmpty()) {
            return false;
        }

        $parent->delete();

        return true;
    }
}