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
                'score' => 3,
            ],
            [
                'name' => 'Korban Bencana',
                'score' => 5,
            ],
            [
                'name' => 'Kelainan Fisik',
                'score' => 7,
            ],
        ];

        foreach ($criterias as $criteria) {
            OtherCriteria::create($criteria);
        }
    }
}
