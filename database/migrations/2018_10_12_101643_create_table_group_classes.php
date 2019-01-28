<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_classes', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('group_id', 36);
            $table->unsignedTinyInteger('hours');
            $table->date('date');
            $table->unsignedInteger('price_per_hour');

            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_classes');
    }
}
