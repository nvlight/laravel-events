<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('evento_id')->references('id')->on('evento_eventos')->onDelete('CASCADE');
            $table->bigInteger('type');
            $table->string('file');
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
        Schema::dropIfExists('evento_attachments');
    }
}