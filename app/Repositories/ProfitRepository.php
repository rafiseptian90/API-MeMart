<?php

namespace App\Repositories;

use App\Http\Resources\ProfitResource;
use App\Models\Profit;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use JsonSerializable;
use Exception;

interface ProfitRepository {
    public function getProfits(): JsonSerializable;
    public function storeProfit(array $requests): bool;
    public function getProfit(int $id): JsonSerializable;
    public function updateProfit(array $requests, int $id): bool;
    public function destroyProfit(int $id): bool;
}

class EloquentProfitRepository implements ProfitRepository {
    
    public function getProfits(): JsonSerializable
    {
        $profits = ProfitResource::collection(
            Profit::with(['students' => function ($student) {
                    $student->whereMonth('date', Carbon::now()->month);
                  }])
                  ->whereHas('students')
                  ->get()
        );

        return $profits;
    }

    public function storeProfit(array $requests): bool
    {
        $profit = Profit::create(Arr::except($requests, ['students', 'date']));
        $profit->students()->attach($requests['students'], ['date' => $requests['date']]);

        if (!$profit) {
            throw new Exception("Unprocessable Entity");
        }

        return true;
    }

    public function getProfit(int $id): JsonSerializable
    {
        $profit = ProfitResource::make(Profit::with(['students'])->findOrFail($id));

        return $profit;
    }

    public function updateProfit(array $requests, int $id): bool
    {
        $profit = Profit::findOrFail($id);
        
        if (Arr::exists($requests, ['students'])) {
            $profit->students()->detach();
            $profit->students()->attach($requests['students'], ['date' => $requests['date']]);
        }
        
        $res = $profit->update(Arr::except($requests, ['students', 'date']));

        if (!$res) {
            throw new Exception("Unprocessable Entity");
        }

        return true;
    }

    public function destroyProfit(int $id): bool
    {
        $profit = Profit::findOrFail($id);

        $profit->delete();

        return true;
    }
}