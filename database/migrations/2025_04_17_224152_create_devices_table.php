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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->string('type', 45)->nullable();
            $table->string('status', 45)->nullable();
            $table->string('protocol', 45)->nullable();
            $table->string('location', 45)->nullable();
             // Clave foránea a users
            $table->foreignId('users_id')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
