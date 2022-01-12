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
                'name' => 'Lengkap',
                'score' => 1,
            ],
            [
                'name' => 'Piatu',
                'score' => 3,
            ],
            [
                'name' => 'Yatim',
                'score' => 5,
            ],
            [
                'name' => 'Yatim Piatu',
                'score' => 7,
            ],
        ];

        foreach ($criterias as $criteria) {
            ParentCompletness::create($criteria);
        }
    }
}
