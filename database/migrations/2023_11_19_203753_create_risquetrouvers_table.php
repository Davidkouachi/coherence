<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisquetrouversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risquetrouvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amelioration_id');
            $table->foreign('amelioration_id')->references('id')->on('ameliorations');
            $table->unsignedBigInteger('risque_id');
            $table->foreign('risque_id')->references('id')->on('risques');
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
        Schema::dropIfExists('risquetrouvers');
    }
}
