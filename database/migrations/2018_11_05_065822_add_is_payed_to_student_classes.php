<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPayedToStudentClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students_classes', function (Blueprint $table) {
            $table->integer('payment')->unsigned()->nullable()->change();
            $table->tinyInteger('is_payed')->unsigned()->default(0);
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
