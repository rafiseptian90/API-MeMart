<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfitStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10; $i++) { 
            DB::table('profit_students')->insert([
                'student_id' => rand(1, 5),
                'profit_id' => rand(1, 3),
                'date' => Carbon::now()->format('Y-m-d'),
                'amount' => rand(20000, 50000)
            ]);
        }
    }
}
