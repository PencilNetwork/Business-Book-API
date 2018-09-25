<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('social_id')->unique();
            $table->string('name');
            $table->string('token');
            $table->string('email')->unique()->nullable();

            // $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('searchers');
    }
}
