<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('test_name');
            $table->string('requested_by');
            $table->string('result')->nullable();
            $table->string('reference_range')->nullable();
            $table->enum('status', ['pending', 'completed', 'abnormal', 'reviewed'])->default('pending');
            $table->text('remarks')->nullable();
            $table->date('test_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};