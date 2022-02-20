<?php

namespace App\Services;

use App\Http\Resources\ProfitStudentResource;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JsonSerializable;

class ProfitStudentService {
    /**
     * @return JsonSerializable
     */
    public function getProfitStudents(): JsonSerializable
    {
        return ProfitStudentResource::collection(
            Student::with(['profile', 'classroom', 'profits'])
                ->whereHas('profits', function($profit){
                    $profit->whereMonth('profit_students.date', Carbon::now()->month);
                })
                ->get()
        )->groupBy('classroom.name');
    }

    /**
     * @param array $requests
     * @return void
     */
    public function storeProfitStudent(array $requests)
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
    }

    /**
     * @param int $id
     * @return JsonSerializable
     */
    public function getProfitStudent(int $id): JsonSerializable
    {
        return ProfitStudentResource::make(
            Student::with(['profile', 'classroom', 'profits'])
                ->findOrFail($id)
        );
    }

    /**
     * @param array $requests
     * @param int $id
     * @return mixed
     */
    public function updateProfitStudent(array $requests, int $id)
    {
        $profitStudent = DB::table('profit_students')
                            ->whereStudentId($id)
                            ->whereDate('date', $requests['date']);

        return $profitStudent->update($requests);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroyProfitStudent(int $id)
    {
        $profitStudent = DB::table('profit_students')
                            ->whereStudentId($id)
                            ->whereDate('date', request()->query('date'));

        return $profitStudent->delete();
    }
}
