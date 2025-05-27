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
        Schema::create('consumes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('measured_at')->nullable(); // ✅ timestamp como en tu estructura
            $table->decimal('energy_consumption', 10, 2)->nullable(); // ✅ para consumo
            $table->decimal('voltage', 10, 2)->nullable();             // ✅ para voltaje
            $table->decimal('current', 10, 4)->nullable(); 
                    // Clave foránea a devices
            $table->foreignId('devices_id')->constrained('devices')->onDelete('restrict')->onUpdate('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumes');
    }
};
