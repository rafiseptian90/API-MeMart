<?php

namespace App\Repositories;

use App\Http\Resources\ProfitStudentResource;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JsonSerializable;

interface ProfitStudentRepository {
    public function getProfitStudents (): JsonSerializable;
    public function storeProfitStudent (array $requests): bool;
    public function getProfitStudent (int $id): JsonSerializable;
    public function updateProfitStudent (array $requests, int $id): bool;
    public function destroyProfitStudent (int $id): bool;
}

class EloquentProfitStudentRepository implements ProfitStudentRepository {

    public function getProfitStudents(): JsonSerializable
    {
        $profitStudents = ProfitStudentResource::collection(
            Student::with(['profile', 'classroom', 'profits'])
                   ->whereHas('profits', function($profit){
                        $profit->whereMonth('profit_students.date', Carbon::now()->month);
                   })
                   ->get()
        )
        ->groupBy('classroom.name');

        return $profitStudents;
    }

    public function storeProfitStudent(array $requests): bool
    {
        foreach ($requests as $request) {
            DB::transaction(function() use($request){
                $student = Student::findOrFail($request->student_id);
                DB::table('profit_students')->updateOrInsert(
                    ['student_id' => $student->id, 'date' => Carbon::parse($request->date)->format('Y-m-d')],
                    [
                        'student_id' => $student->id,
                        'profit_id' => $request->profit_id, 
                        'date' => $request->date,
                        'amount' => $request->amount
                    ]
                );
            });
        }

        return true;
    }

    public function getProfitStudent(int $id): JsonSerializable
    {
        $student = ProfitStudentResource::make(
            Student::with(['profile', 'classroom', 'profits'])
                   ->findOrFail($id)
        );

        return $student;
    }

    public function updateProfitStudent(array $requests, int $id): bool
    {
        $profitStudent = DB::table('profit_students')
                            ->whereStudentId($id)
                            ->whereDate('date', $requests['date']);

        $profitStudent->update($requests);

        return true;
    }

    public function destroyProfitStudent(int $id): bool
    {
        DB::table('profit_students')
          ->whereStudentId($id)
          ->whereDate('date', request()->query('date'))
          ->delete();

        return true;
    }
}