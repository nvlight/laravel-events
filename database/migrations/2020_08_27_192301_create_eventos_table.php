<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_eventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('description');
            $table->unsignedTinyInteger('status')->default(1);
            $table->date('date')->default(date('Y-m-d')); // DB::raw('CURRENT_DATE')
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
        Schema::dropIfExists('evento_eventos');
    }
}
