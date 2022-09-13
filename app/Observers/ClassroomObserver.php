<?php

namespace App\Observers;

use App\Models\Classroom;
use Illuminate\Support\Facades\Redis;

class ClassroomObserver
{
    /**
     * Handle the Classroom "created" event.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return void
     */
    public function created(Classroom $classroom)
    {
         Redis::del('classroom.lists');
    }

    /**
     * Handle the Classroom "updated" event.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return void
     */
    public function updated(Classroom $classroom)
    {
         Redis::del('classroom.lists');
    }

    /**
     * Handle the Classroom "deleted" event.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return void
     */
    public function deleted(Classroom $classroom)
    {
         Redis::del('classroom.lists');
    }

    /**
     * Handle the Classroom "restored" event.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return void
     */
    public function restored(Classroom $classroom)
    {
        //
    }

    /**
     * Handle the Classroom "force deleted" event.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return void
     */
    public function forceDeleted(Classroom $classroom)
    {
        //
    }
}
