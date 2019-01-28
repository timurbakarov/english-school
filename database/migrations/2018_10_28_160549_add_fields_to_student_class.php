<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToStudentClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students_classes', function (Blueprint $table) {
            $table->string('group_id', 36)->nullable();
            $table->date('date')->nullable();
            $table->integer('price_per_hour')->unsigned()->nullable();
            $table->tinyInteger('duration')->unsigned()->nullable();
            $table->integer('payment')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students_classes', function (Blueprint $table) {
            //
        });
    }
}
