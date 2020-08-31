<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoEventoTagValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_evento_tag_values', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('evento_evento_tags_id')->index();

            $table->bigInteger('value')->default(0);
            $table->string('caption',50)->nullable();
            $table->timestamps();

            $table->foreign('evento_evento_tags_id')->references('id')->on('evento_evento_tags')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_evento_tag_values');
    }
}
