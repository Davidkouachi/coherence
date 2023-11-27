<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionAmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_ams', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->unsignedBigInteger('poste_id');
            $table->foreign('poste_id')->references('id')->on('postes');
            $table->unsignedBigInteger('risque_id')->nullable();
            $table->foreign('risque_id')->references('id')->on('risques');
            $table->unsignedBigInteger('risque_id_am')->nullable();
            $table->foreign('risque_id_am')->references('id')->on('risque_ams');
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
        Schema::dropIfExists('action_ams');
    }
}
