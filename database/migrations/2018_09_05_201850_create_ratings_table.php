<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rating'); 
            
            $table->integer('bussines_id')->unsigned();
            $table->foreign('bussines_id')->references('id')->on('bussines')->onDelete('cascade');
            
            $table->integer('searcher_id')->unsigned();
            $table->foreign('searcher_id')->references('id')->on('searchers')->onDelete('cascade');

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
        Schema::dropIfExists('ratings');
    
    }
}
