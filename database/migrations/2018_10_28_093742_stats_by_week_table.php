<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatsByWeekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats_by_week', function (Blueprint $table) {
            $table->integer('year')->unsigned();
            $table->tinyInteger('month')->unsigned();
            $table->tinyInteger('week')->unsigned();
            $table->integer('income')->unsigned()->nullable();
            $table->integer('hours_worked')->unsigned()->nullable();
            $table->integer('hours_student_worked')->unsigned()->nullable();
            $table->integer('money_worked')->unsigned()->nullable();

            $table->index(['year', 'week']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats_by_week');
    }
}
