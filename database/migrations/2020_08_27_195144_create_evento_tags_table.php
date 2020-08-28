<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('color',7);
            $table->string('img')->nullable();
            $table->timestamps();
        });

        Schema::create('evento_evento_tags', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->unsignedInteger('evento_id')->references('id')->on('evento_eventos')->onDelete('CASCADE');
            $table->unsignedInteger('tag_id')->references('id')->on('evento_tags')->onDelete('CASCADE');
            $table->timestamps();
            $table->primary(['evento_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_tags');
        Schema::dropIfExists('evento_evento_tags');
    }
}
