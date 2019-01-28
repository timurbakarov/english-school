<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudentsStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_stats', function (Blueprint $table) {
            $table->string('student_id', 36);
            $table->integer('payments')->unsigned()->nullable();
            $table->integer('visited_classes_in_money')->unsigned()->nullable();
            $table->integer('visited_classes')->unsigned()->nullable();
            $table->integer('missed_classes')->unsigned()->nullable();

            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_stats');
    }
}
