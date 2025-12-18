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
            $table->foreignId('journal_upload_id')->constrained()->cascadeOnDelete();

            $table->string('no_akun', 30);
            $table->date('tanggal')->nullable();
            $table->decimal('amount', 20, 8)->nullable();
            $table->enum('type', ['credit in', 'credit out']);

            $table->text('raw_line');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_credit_facilities');
    }
};
