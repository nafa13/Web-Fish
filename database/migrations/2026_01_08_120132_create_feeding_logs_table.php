<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('feeding_logs', function (Blueprint $table) {
        $table->id();
        $table->timestamp('fed_at'); // Waktu pakan
        // Tambahkan kolom lain jika perlu, misal: $table->integer('amount');
        $table->timestamps();
    });
}

   
};
