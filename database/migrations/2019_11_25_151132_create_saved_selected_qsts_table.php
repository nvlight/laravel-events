<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedSelectedQstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_selected_qsts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('test_number');
            $table->bigInteger('shedule_id');
            $table->bigInteger('test_id');
            $table->bigInteger('selected_qsts_id');
            $table->integer('qsts_number');
            $table->string('qsts_answer')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_selected_qsts');
    }
}
