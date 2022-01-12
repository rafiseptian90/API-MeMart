<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')
                  ->constrained('classrooms')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('profile_id')
                  ->constrained('profiles')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('parent_completness_id')
                  ->constrained('parent_completnesses')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('parent_income_id')
                  ->constrained('parent_incomes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('other_criteria_id')
                  ->constrained('other_criterias')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->char('nisn', 10);
            $table->tinyInteger('is_reseller');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
