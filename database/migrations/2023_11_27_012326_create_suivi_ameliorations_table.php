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
            $table->string('nature')->nullable();
            $table->string('type')->nullable();
            $table->text('commentaire')->nullable();
            $table->text('trouve')->nullable();
            $table->text('commentaire_am')->nullable();
            $table->date('date_action')->nullable();
            $table->dateTime('date_suivi')->nullable();
            $table->date('delai')->nullable();
            $table->string('statut')->nullable();
            $table->unsignedBigInteger('amelioration_id');
            $table->foreign('amelioration_id')->references('id')->on('ameliorations');
            $table->unsignedBigInteger('action_id');
            $table->foreign('action_id')->references('id')->on('actions');
            $table->unsignedBigInteger('risque_id')->nullable();
            $table->foreign('risque_id')->references('id')->on('risques');
            $table->unsignedBigInteger('cause_id')->nullable();
            $table->foreign('cause_id')->references('id')->on('causes');
            $table->unsignedBigInteger('processus_id');
            $table->foreign('processus_id')->references('id')->on('processuses');
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
