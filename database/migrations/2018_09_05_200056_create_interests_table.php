<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
 
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('searcher_id')->unique();
            $table->string('categories_ids'); // categories ids 
            $table->string('city_id'); // city id 
            $table->string('regoins_ids');  // regoins ids 
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
        Schema::dropIfExists('interests');
    }
}
