<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePisosTable extends Migration
{
    public function up()
    {
        Schema::create('pisos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('localidad_id')->constrained('localidades')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pisos');
    }
}
