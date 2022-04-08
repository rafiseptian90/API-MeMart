<?php

namespace App\Repositories;

use App\Http\Resources\OtherCriteriaResource;
use App\Models\OtherCriteria;
use JsonSerializable;
use Exception;

class OtherCriteriaRepository {
    /**
     * @return JsonSerializable
     */
    public function getOtherCriterias(): JsonSerializable
    {
        return OtherCriteriaResource::collection(OtherCriteria::latest()->get());
    }

    /**
     * @param array $requests
     * @return mixed
     */
    public function storeOtherCriteria(array $requests)
    {
        return OtherCriteria::create($requests);
    }

    /**
     * @param int $id
     * @return JsonSerializable
     */
    public function getOtherCriteria(int $id): JsonSerializable
    {
        return OtherCriteriaResource::make(
            OtherCriteria::with(['students'])
                ->findOrFail($id)
        );
    }

    /**
     * @param array $requests
     * @param int $id
     * @return bool
     */
    public function updateOtherCriteria(array $requests, int $id): bool
    {
        return OtherCriteria::findOrFail($id)->update($requests);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function destroyOtherCriteria(int $id)
    {
        $criteria = OtherCriteria::findOrFail($id);

        if (!$criteria->students->isEmpty()) {
            throw new Exception("Cannot delete this other criteria because they have student data");
        }

        return $criteria->delete();
    }
}
