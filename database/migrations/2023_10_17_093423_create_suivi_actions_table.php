<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuiviActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suivi_actions', function (Blueprint $table) {
            $table->id();
            $table->string('efficacite')->nullable();
            $table->text('commentaire')->nullable();
            $table->date('date_action')->nullable();
            $table->dateTime('date_suivi')->nullable();
            $table->date('delai')->nullable();
            $table->string('statut')->nullable();
            $table->unsignedBigInteger('action_id');
            $table->foreign('action_id')->references('id')->on('actions');
            $table->unsignedBigInteger('processus_id');
            $table->foreign('processus_id')->references('id')->on('processuses');
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
        Schema::dropIfExists('suivi_actions');
    }
}
