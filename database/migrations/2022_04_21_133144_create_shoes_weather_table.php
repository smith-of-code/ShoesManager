<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoesWeatherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoes_weather', function (Blueprint $table) {
            $table->bigInteger('shoes_id')->unsigned()->nullable();
            $table->bigInteger('weather_id')->unsigned()->nullable();

            $table->foreign('shoes_id')->references('id')->on('shoes');
            $table->foreign('weather_id')->references('id')->on('weathers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoes_weather');
    }
}
