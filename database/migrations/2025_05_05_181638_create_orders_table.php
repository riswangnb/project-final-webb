<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->decimal('weight', 8, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->date('pickup_date');
            $table->date('delivery_date');
            $table->text('notes')->nullable();
            $table->enum('pickup_service', ['yes', 'no'])->default('no');
            $table->enum('delivery_service', ['yes', 'no'])->default('no');
            $table->enum('payment_method', ['online', 'cash'])->default('cash');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};