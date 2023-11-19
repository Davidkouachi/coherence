<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuiviAmeliorationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivi_ameliorations', function (Blueprint $table) {
            $table->id();
            $table->string('efficacite')->nullable();
            $table->text('commentaire')->nullable();
            $table->date('date_action')->nullable();
            $table->dateTime('date_suivi')->nullable();
            $table->unsignedBigInteger('amelioration_id');
            $table->foreign('amelioration_id')->references('id')->on('ameliorations');
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
        Schema::dropIfExists('suivi_ameliorations');
    }
}
