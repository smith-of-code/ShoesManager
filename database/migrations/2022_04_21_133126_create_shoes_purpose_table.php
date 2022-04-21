<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoesPurposeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoes_purpose', function (Blueprint $table) {
                $table->bigInteger('shoes_id')->unsigned()->nullable();
                $table->bigInteger('purpose_id')->unsigned()->nullable();

                $table->foreign('shoes_id')->references('id')->on('shoes');
                $table->foreign('purpose_id')->references('id')->on('purposes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoes_purpose');
    }
}
