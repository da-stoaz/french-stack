<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->time('starts_at');
            $table->time('ends_at');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index(['date', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
