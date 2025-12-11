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
    Schema::create('feeding_logs', function (Blueprint $table) {
        $table->id();
        $table->timestamp('fed_at'); // Waktu pemberian pakan
        $table->string('status')->default('success'); // success/failed
        $table->enum('type', ['manual', 'scheduled']); // Manual atau terjadwal
        $table->foreignId('user_id')->nullable()->constrained(); // Siapa yang memberi makan (jika manual)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_logs');
    }
};
