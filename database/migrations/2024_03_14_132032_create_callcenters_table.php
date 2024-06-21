<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('callcenters', function (Blueprint $table) {
            $table->id();
            $table->string('extension', 6)->unique();
            $table->string('nombres', 100)->nullable();
            $table->string('usuario', 20)->nullable();
            $table->string('contrasena', 10)->nullable();
            $table->string('servicio', 15)->nullable();
            $table->string('acceso', 30)->nullable();
            $table->string('localidad', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callcenters');
    }
};
