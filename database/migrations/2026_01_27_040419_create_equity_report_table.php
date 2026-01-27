<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equity_report', function (Blueprint $table) {
            $table->id();
            $table->string('no_akun');
            $table->string('group')->nullable();

            $table->decimal('balance', 18, 2);
            $table->decimal('credit', 18, 2)->default(0);
            $table->decimal('equity', 18, 2);
            $table->decimal('margin', 18, 2)->nullable();
            $table->decimal('free_margin', 18, 2)->nullable();
            $table->decimal('floating_pl', 18, 2)->nullable();

            $table->decimal('margin_level', 8, 2)->nullable();
            $table->string('risk_status')->nullable(); // NORMAL / MC / STOP_OUT
            $table->date('report_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equity_report');
    }
};
