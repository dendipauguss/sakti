<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_market_executions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_upload_id')->constrained()->cascadeOnDelete();

            $table->string('no_akun', 20);
            $table->string('no_tiket', 20);

            $table->date('tanggal');

            $table->unsignedBigInteger('request_time');
            $table->unsignedBigInteger('confirm_time');

            $table->unsignedBigInteger('delay_microseconds');
            $table->decimal('delay_seconds', 10, 3);
            $table->string('delay_formatted', 15);

            $table->longText('request_raw');
            $table->longText('confirm_raw');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_market_executions');
    }
};
