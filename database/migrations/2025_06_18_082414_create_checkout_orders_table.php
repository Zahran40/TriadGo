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
        Schema::create('checkout_orders', function (Blueprint $table) {
            $table->id();
            
            // User Information
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            
            // Order Information
            $table->string('order_id')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'paid', 'failed', 'cancelled', 'expired'])->default('pending');
            
            // Customer Information
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country');
            
            // Payment Information
            $table->string('payment_method')->default('midtrans');
            $table->string('payment_gateway_order_id')->nullable();
            $table->string('payment_gateway_transaction_id')->nullable();
            $table->json('payment_details')->nullable();
            
            // Cart Items
            $table->json('cart_items');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(25.00);
            $table->decimal('tax_amount', 10, 2);
            $table->string('coupon_code')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            
            // Additional Information
            $table->text('notes')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['email', 'created_at']);
            $table->index('payment_gateway_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_orders');
    }
};