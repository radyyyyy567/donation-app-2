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
        Schema::create('donation_logs', function (Blueprint $table) {
             $table->id();
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade');
            $table->dateTime('waktu_update');
            $table->enum('status', ['pending', 'sukses', 'gagal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_logs');
    }
};
