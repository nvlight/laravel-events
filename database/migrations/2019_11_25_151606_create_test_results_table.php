<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('test_number');
            $table->bigInteger('shedule_id');
            $table->bigInteger('test_id');
            $table->bigInteger('selected_qsts_id');
            //$table->bigInteger('saved_selected_qsts_id');
            $table->timestamp('test_started_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('test_ended_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('test_status');
            $table->integer('ball')->default(0);
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
        Schema::dropIfExists('test_results');
    }
}
