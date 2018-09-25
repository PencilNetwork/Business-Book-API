<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBussinesTable extends Migration
{

    public function up()
    {
        Schema::create('bussines', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('name'); 
            $table->string('image'); 
            $table->string('description'); 
            $table->string('logo')->nullable(); 
            $table->string('contact_number'); 
            $table->string('city'); 
            $table->string('regoin')->nullable(); 
            $table->string('address'); 
            $table->string('langitude'); 
            $table->string('lattitude'); 
            
            $table->integer('owner_id')->unsigned(); //bussines_man_id
            $table->foreign('owner_id')->references('id')->on('owners');
            
            $table->integer('category_id')->unsigned(); 
            $table->foreign('category_id')->references('id')->on('categories');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bussines');
    }
}
