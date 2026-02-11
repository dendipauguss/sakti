<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equity_comparisons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equity_upload_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('login', 20);
            $table->string('name')->nullable();
            $table->decimal('equity_old', 15, 2)->nullable();
            $table->decimal('equity_new', 15, 2)->nullable();
            $table->decimal('floating_pl_old', 15, 2)->nullable();
            $table->decimal('floating_pl_new', 15, 2)->nullable();
            $table->decimal('credit_old', 15, 2)->nullable();
            $table->decimal('credit_new', 15, 2)->nullable();
            $table->decimal('deposit_old', 15, 2)->nullable();
            $table->decimal('deposit_new', 15, 2)->nullable();
            $table->decimal('selisih', 18, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->enum('status', [
                'SAMA',
                'NAIK',
                'TURUN',
                'TIDAK_LENGKAP'
            ]);

            $table->timestamps();

            $table->index('login');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equity_comparisons');
    }
};
