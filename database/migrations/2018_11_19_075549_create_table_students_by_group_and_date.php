<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudentsByGroupAndDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_by_group_and_date', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->unsigned();
            $table->tinyInteger('month')->unsigned();
            $table->string('group_id', 36);
            $table->string('student_id', 36);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_by_group_and_date');
    }
}
