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
        Schema::create('custom_invoices', function (Blueprint $table) {
            $table->id();

            $table->string('serviceName')->nullable();
            $table->integer('price')->nullable();
            $table->string('duration')->nullable();
            $table->longText('features')->nullable();
            $table->longText('link')->nullable();
            $table->text('country')->nullable();
            
            $table->string('clientName')->nullable();
            $table->string('clientEmail')->nullable();
            $table->string('clientPhone')->nullable();

            $table->string('paymentMethod')->nullable();
            $table->text('transactionId')->nullable();
            $table->integer('amountPaid')->nullable();
            $table->integer('tips')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_invoices');
    }
};
