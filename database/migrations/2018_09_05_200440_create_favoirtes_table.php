<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoirtesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favoirtes', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('bussines_id')->unsigned();
            $table->foreign('bussines_id')->references('id')->on('bussines');
            
            $table->integer('searcher_id')->unsigned();
            $table->foreign('searcher_id')->references('id')->on('searchers');

            

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
        Schema::dropIfExists('favoirtes');
       
    }
}
