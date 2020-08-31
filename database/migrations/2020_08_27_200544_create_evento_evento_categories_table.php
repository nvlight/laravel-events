<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoEventoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_evento_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evento_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->timestamps();

            $table->foreign('evento_id')->references('id')->on('evento_eventos')->onDelete('CASCADE');
            $table->foreign('category_id')->references('id')->on('evento_categories')->onDelete('CASCADE');

            //$table->primary(['evento_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_evento_categories');
    }
}
