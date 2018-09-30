<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // related files table for bussines owner 
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            
            $table->integer('bussines_id')->unsigned();
            $table->foreign('bussines_id')->references('id')->on('bussines')->onDelete('cascade');

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
        Schema::dropIfExists('files');
    }
}
