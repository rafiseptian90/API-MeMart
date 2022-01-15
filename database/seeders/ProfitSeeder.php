<?php

namespace Database\Seeders;

use App\Models\Profit;
use Illuminate\Database\Seeder;

class ProfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profits = [
            [
                'amount' => 'Less than Rp 50.000',
                'score' => 5
            ],
            [
                'amount' => 'More than Rp 50.000 and Less than 100.000',
                'score' => 7
            ],
            [
                'amount' => 'More than Rp 100.000',
                'score' => 10
            ],
        ];

        foreach ($profits as $profit) {
            Profit::create($profit);
        }
    }
}
