<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports', function(Blueprint $table){

            $table->increments('id')->comment("field to store sport's number idenfifier");
            $table->string('name', 30)->comment("field to store sport's name, must be unique")->unique();
            $table->string('description', 2000)->comment("field to store sport's description");
            $table->timestamps();
            $table->softDeletes();


        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExist('sports');
    }
}

//
