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
        Schema::create('automations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->json('conditions')->nullable();
            $table->json('action')->nullable();
            $table->dateTime('time_program')->nullable();
                    // Relación con usuarios
            $table->foreignId('users_id')->constrained('users')->onDelete('restrict')->onUpdate('restrict');

    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automations');
    }
};
