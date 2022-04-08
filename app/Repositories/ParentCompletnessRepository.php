<?php

namespace App\Repositories;

use App\Http\Resources\ParentCompletnessResource;
use App\Models\ParentCompletness;
use JsonSerializable;
use Exception;

class ParentCompletnessRepository {
    /**
     * @return JsonSerializable
     */
    public function getParentCompletnesses(): JsonSerializable
    {
        return ParentCompletnessResource::collection(
            ParentCompletness::latest()->get()
        );
    }

    /**
     * @param array $requests
     * @return mixed
     */
    public function storeParentCompletness(array $requests)
    {
        return ParentCompletness::create($requests);
    }

    /**
     * @param int $id
     * @return JsonSerializable
     */
    public function getParentCompletness(int $id): JsonSerializable
    {
        return ParentCompletnessResource::make(
            ParentCompletness::with(['students'])
                ->findOrFail($id)
        );
    }

    /**
     * @param array $requests
     * @param int $id
     * @return mixed
     */
    public function updateParentCompletness(array $requests, int $id)
    {
        return ParentCompletness::findOrFail($id)->update($requests);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function destroyParentCompletness(int $id)
    {
        $parent = ParentCompletness::findOrFail($id);

        if (!$parent->students->isEmpty()) {
            throw new Exception("Cannot delete this parent completness because they have a student data");
        }

        return $parent->delete();
    }
}
