<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoEventoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_evento_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('evento_id')->references('id')->on('evento_eventos')->onDelete('CASCADE');
            $table->foreign('tag_id')->references('id')->on('evento_tags')->onDelete('CASCADE');
            //$table->primary(['evento_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_evento_tags');
    }
}
