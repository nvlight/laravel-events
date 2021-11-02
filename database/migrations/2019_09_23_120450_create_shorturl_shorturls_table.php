<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShorturlShorturlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shorturl_shorturls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->default(0);
            $table->string('longurl', 1111);
            $table->string('shorturl',1111);
            $table->string('description',170);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shorturl_shorturls', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // очень умно, нужно передать массив строк :smirk
        });
        Schema::dropIfExists('shorturl_shorturls');
    }
}
