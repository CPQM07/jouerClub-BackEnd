<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->increments('id')->comment("field to store workshop's number idenfifier, it's a foreign key")->unsigned();;
            $table->string('name', 100)->comment("field to store workshop's name");
            $table->string('description', 1000)->comment("field to store workshop's description");
            $table->string('ubication', 60)->comment("field to store workshop's ubication")->nullable();
            $table->integer('max_jouer')->comment("field to store how many jouers will have the workshop at most")->nullable();
            $table->string('lat', 20)->comment("field to store workshop's latitude for his ubication");
            $table->string('lng', 20)->comment("field to store workshop's longitude for his ubication");
            $table->dateTime('time_begin')->comment("field to store when the workshop's it's start");
            $table->dateTime('time_end')->comment("field to store when the workshop's it's close");
            $table->enum('status', ['pending', 'now', 'finished'])->comment("field to store  workshop's status, default value = pending")->default('pending');
            $table->integer('coach_id')->comment("field to store court's number idenfifier, it's a foreign key")->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('coach_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
}