<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmeliorationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ameliorations', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->date('date_fiche');
            $table->string('lieu');
            $table->string('detecteur');
            $table->string('non_conformite');
            $table->text('consequence');
            $table->text('cause');
            $table->string('choix_select');
            $table->string('nature');
            $table->text('commentaire');
            $table->unsignedBigInteger('action_id');
            $table->foreign('action_id')->references('id')->on('actions');
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
        Schema::dropIfExists('ameliorations');
    }
}
