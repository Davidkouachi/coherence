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
            $table->date('date_cloture1')->nullable();
            $table->string('lieu');
            $table->string('detecteur');
            $table->string('non_conformite');
            $table->text('consequence');
            $table->text('cause');
            $table->string('choix_select');
            $table->string('statut');
            $table->date('date_validation')->nullable();
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
