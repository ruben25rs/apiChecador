<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('nombre');
            $table->string('apellidop');
            $table->string('apellidom')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->longText('descriptor')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('sincronizado');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('plantel_id');
            $table->foreign('plantel_id')->references('id')->on('planteles');
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
        Schema::dropIfExists('docentes');
    }
}
