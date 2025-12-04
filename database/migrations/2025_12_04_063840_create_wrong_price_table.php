<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wrong_price', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nomor_akun')->unique();
            $table->date('tanggal');
            $table->bigInteger('tiket');
            $table->bigInteger('close_order');
            $table->enum('tipe', ['buy', 'sell']);
            $table->bigInteger('bid');
            $table->bigInteger('ask');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wrong_price');
    }
};
