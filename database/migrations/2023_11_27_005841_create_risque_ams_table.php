<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisqueAmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risque_ams', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('processus_id');
            $table->foreign('processus_id')->references('id')->on('processuses');
            $table->unsignedBigInteger('poste_id');
            $table->foreign('poste_id')->references('id')->on('postes');
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
        Schema::dropIfExists('risque_ams');
    }
}
