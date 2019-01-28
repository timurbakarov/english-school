<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_store', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('aggregate_id', 36);
            $table->string('event_name');
            $table->double('event_timestamp')->unsigned();
            $table->text('payload');

            $table->index('aggregate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_store');
    }
}
