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
            $table->unsignedInteger('evento_id')->references('id')->on('evento_eventos')->onDelete('CASCADE');
            $table->unsignedInteger('category_id')->references('id')->on('evento_categories')->onDelete('CASCADE');
            $table->timestamps();
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
