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
    Schema::create('sensor_data', function (Blueprint $table) {
        $table->id();
        $table->float('temperature')->nullable(); // Suhu Air (Celcius)
        $table->float('ph_level')->nullable();    // Derajat Keasaman (pH)
        $table->float('turbidity')->nullable();   // Kekeruhan (NTU)
        $table->integer('feed_level')->nullable(); // Sisa Pakan (%)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
