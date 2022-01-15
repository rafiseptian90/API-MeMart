<?php

namespace Database\Seeders;

use App\Models\OtherCriteria;
use Illuminate\Database\Seeder;

class OtherCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criterias = [
            [
                'name' => 'Normal',
                'score' => 5,
            ],
            [
                'name' => 'Korban Bencana',
                'score' => 7,
            ],
            [
                'name' => 'Kelainan Fisik',
                'score' => 10,
            ],
        ];

        foreach ($criterias as $criteria) {
            OtherCriteria::create($criteria);
        }
    }
}
