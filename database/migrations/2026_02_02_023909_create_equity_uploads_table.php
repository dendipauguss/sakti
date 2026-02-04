<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equity_uploads', function (Blueprint $table) {
            $table->id();

            $table->string('file_1_name');
            $table->string('file_2_name');

            // Optional: periode / tahun
            $table->string('periode_1')->nullable(); // contoh: 2024
            $table->string('periode_2')->nullable(); // contoh: 2025

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equity_uploads');
    }
};
