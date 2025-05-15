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
            $table->dateTime('measured_at')->nullable(); // ✅ mejor para consultas por fecha
                                                         // Se puede cambiar a ->date() si se va a usar fechas reales (se evaluara depende de las API)
            $table->string('energy_consumption', 45)->nullable();
            $table->string('voltage', 45)->nullable();
            $table->string('current', 45)->nullable();
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
