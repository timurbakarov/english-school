<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RebuildPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payments');

        Schema::create('payments', function (Blueprint $table) {
            $table->string('payment_id', 36);
            $table->string('student_id', 36)->nullable();
            $table->integer('amount')->unsigned();
            $table->date('date');
            $table->string('type');
            $table->tinyInteger('status')->unsigned();
            $table->integer('order_number')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
