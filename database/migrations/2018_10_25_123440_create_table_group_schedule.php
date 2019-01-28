<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_schedule', function (Blueprint $table) {
            $table->string('group_id', 36);
            $table->tinyInteger('day_of_week')->unsigned();
            $table->tinyInteger('hour')->unsigned();
            $table->tinyInteger('minutes')->unsigned();
            $table->tinyInteger('duration')->unsigned();

            $table->index(['group_id', 'day_of_week', 'hour', 'minutes']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_schedule');
    }
}
