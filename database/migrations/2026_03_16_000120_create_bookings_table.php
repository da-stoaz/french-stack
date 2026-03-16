<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignUuid('time_slot_id')->constrained('time_slots')->cascadeOnDelete();
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('patient_phone')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('confirmation_token')->unique();
            $table->timestamps();

            $table->unique('time_slot_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
