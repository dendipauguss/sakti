<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('same_ip_publik', function (Blueprint $table) {
            $table->id();
            $table->string('no_akun', 30);
            $table->date('tanggal')->nullable();
            // simpan TANPA milidetik
            $table->time('waktu', 3)->nullable();
            $table->string('ip_address_publik', 45);
            $table->string('filename', 255);
            $table->text('raw_line')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('same_ip_publik');
    }
};
