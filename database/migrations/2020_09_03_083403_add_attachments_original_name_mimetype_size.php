<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttachmentsOriginalNameMimetypeSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evento_attachments', function (Blueprint $table) {
            $table->string('originalname',155);
            $table->string('mimetype');
            $table->unsignedBigInteger('size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evento_attachments', function (Blueprint $table) {
            $table->dropColumn('originalname');
            $table->dropColumn('mimetype');
            $table->dropColumn('size');
        });
    }
}
