<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectedQstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selected_qsts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('number'); // номер выборки
            $table->bigInteger('test_id');
            $table->bigInteger('theme_id');
            $table->bigInteger('qsts_count')->default(0);
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
        Schema::dropIfExists('selected_qsts');
    }
}
