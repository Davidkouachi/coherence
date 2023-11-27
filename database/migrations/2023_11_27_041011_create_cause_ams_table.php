<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCauseAmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cause_ams', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('risque_id');
            $table->foreign('risque_id')->references('id')->on('risque_ams');
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
        Schema::dropIfExists('cause_ams');
    }
}
