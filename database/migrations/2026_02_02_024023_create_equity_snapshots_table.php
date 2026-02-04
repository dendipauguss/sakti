<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equity_snapshots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equity_upload_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('login', 20);

            $table->decimal('equity', 18, 2);

            // penanda asal file
            $table->enum('source', ['file_1', 'file_2']);

            $table->timestamps();

            $table->index(['login', 'source']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equity_snapshots');
    }
};
