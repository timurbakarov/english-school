<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudyClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_classes', function (Blueprint $table) {
            $table->string('study_class_id', 36);
            $table->string('group_id', 36);
            $table->date('date');
            $table->integer('price_per_hour')->unsigned();
            $table->tinyInteger('duration')->unsigned();

            $table->index('study_class_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_classes');
    }
}
