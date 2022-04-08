<?php

namespace App\Repositories;

use App\Http\Resources\ProfitResource;
use App\Models\Profit;
use Carbon\Carbon;
use JsonSerializable;

class ProfitRepository {
    /**
     * @return JsonSerializable
     */
    public function getProfits(): JsonSerializable
    {
        return ProfitResource::collection(
            Profit::with(['students' => function ($student) {
                        $student->with(['profile'])->whereMonth('date', Carbon::now()->month);
                    }])
                    ->get()
        );
    }

    /**
     * @param array $requests
     * @return mixed
     */
    public function storeProfit(array $requests)
    {
        return Profit::create($requests);
    }

    /**
     * @param int $id
     * @return JsonSerializable
     */
    public function getProfit(int $id): JsonSerializable
    {
        return ProfitResource::make(Profit::with(['students' => function($student){
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
    public function updateProfit(array $requests, int $id)
    {
        return Profit::findOrFail($id)->update($requests);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroyProfit(int $id)
    {
        $profit = Profit::findOrFail($id);

        $profit->students()->delete();
        return $profit->delete();
    }
}
