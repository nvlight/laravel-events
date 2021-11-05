<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet; // посмотрим оставить его сейчас или же нет.

class CreateShorturlCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shorturl_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('parent_id');
            $table->string('name', 111);
            $table->string('slug');
            $table->string('img')->nullable();
            $table->timestamps();

            // появился потому что в сидере есть children, который позволяет в цикле создать дочерние каталоги.
            // NestedSet::columns($table);

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
        Schema::table('shorturl_categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // очень умно, нужно передать массив строк :smirk
        });
        Schema::dropIfExists('shorturl_categories');
    }
}
