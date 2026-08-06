<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->enum('service', [
                'Telemedicine Consultation',
                'Physical Consultation',
                'Laboratory Test',
                'Pharmacy',
                'Emergency',
                'Admission'
            ]);
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', [
                'Cash',
                'Credit Card',
                'Debit Card',
                'Bank Transfer',
                'Health Insurance',
                'Medicare / Medicaid'
            ])->nullable();
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};