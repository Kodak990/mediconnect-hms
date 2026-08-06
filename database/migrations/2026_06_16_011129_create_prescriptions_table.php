<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('doctor_name');
            $table->string('medication');
            $table->string('dosage');
            $table->string('frequency');
            $table->integer('duration_days');
            $table->integer('refills')->default(0);
            $table->text('instructions')->nullable();
            $table->enum('status', ['active', 'dispensed', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};