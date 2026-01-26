<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_credit_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_upload_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('no_akun', 30);
            $table->string('no_tiket', 20);

            $table->date('tanggal')->nullable();

            // simpan TANPA milidetik
            $table->time('waktu', 3)->nullable();

            $table->string('ip_address', 45);

            // UANG = decimal
            $table->decimal('credit_in', 15, 2)->default(0);
            $table->decimal('credit_out', 15, 2)->default(0);

            $table->text('raw_line')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_credit_facilities');
    }
};
