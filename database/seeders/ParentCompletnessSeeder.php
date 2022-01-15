<?php

namespace Database\Seeders;

use App\Models\ParentCompletness;
use Illuminate\Database\Seeder;

class ParentCompletnessSeeder extends Seeder
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
                'type' => 'Lengkap',
                'score' => 3,
            ],
            [
                'type' => 'Piatu',
                'score' => 5,
            ],
            [
                'type' => 'Yatim',
                'score' => 7,
            ],
            [
                'type' => 'Yatim Piatu',
                'score' => 10,
            ],
        ];

        foreach ($criterias as $criteria) {
            ParentCompletness::create($criteria);
        }
    }
}
