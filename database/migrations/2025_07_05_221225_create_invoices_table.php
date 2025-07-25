<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->comment('User ID of the candidate');
            $table->string('invoice_number')->unique()->comment('Unique invoice number');
            $table->date('invoice_date')->comment('Date of the invoice');
            $table->decimal('invoice_amount', 10, 2)->comment('Total amount of the invoice');
            $table->enum('payment_status', ['cash', 'online'])->default('cash')->comment('Payment status of the invoice');
            $table->text('invoice_description')->nullable()->comment('Description of the invoice');
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending')->comment('Status of the invoice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
