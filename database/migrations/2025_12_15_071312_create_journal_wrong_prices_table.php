<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_wrong_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_upload_id')->constrained()->cascadeOnDelete();

            $table->string('no_akun', 30);
            $table->string('no_tiket', 30);
            $table->date('tanggal');

            $table->enum('exec_type', ['buy', 'sell']);
            $table->decimal('completed_price', 20, 8);
            $table->decimal('bid_price', 20, 8)->nullable();
            $table->decimal('ask_price', 20, 8)->nullable();

            $table->text('confirm_raw');
            $table->text('close_order_raw');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_wrong_prices');
    }
};
