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
        Schema::table('checkout_orders', function (Blueprint $table) {
            // Add tracking and shipping fields
            $table->string('invoice_code')->nullable()->after('order_id');
            $table->string('tracking_number')->nullable()->after('invoice_code');
            $table->enum('shipping_status', ['pending', 'processing', 'shipped', 'in_transit', 'delivered', 'returned'])
                  ->default('pending')->after('status');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled', 'expired'])
                  ->default('pending')->after('shipping_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkout_orders', function (Blueprint $table) {
            $table->dropColumn(['invoice_code', 'tracking_number', 'shipping_status', 'payment_status']);
        });
    }
};
