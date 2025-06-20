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
            // Check if first_name and last_name columns exist before dropping
            if (Schema::hasColumn('checkout_orders', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if (Schema::hasColumn('checkout_orders', 'last_name')) {
                $table->dropColumn('last_name');
            }
            
            // Add name column if not exists
            if (!Schema::hasColumn('checkout_orders', 'name')) {
                $table->string('name')->after('status');
            }
            
            // Add user_id column if not exists
            if (!Schema::hasColumn('checkout_orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            
            // Update payment_method column to default to 'midtrans'
            if (Schema::hasColumn('checkout_orders', 'payment_method')) {
                $table->string('payment_method')->default('midtrans')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkout_orders', function (Blueprint $table) {
            // Add back first_name and last_name columns
            if (!Schema::hasColumn('checkout_orders', 'first_name')) {
                $table->string('first_name')->after('status');
            }
            if (!Schema::hasColumn('checkout_orders', 'last_name')) {
                $table->string('last_name')->after('first_name');
            }
            
            // Drop name column
            if (Schema::hasColumn('checkout_orders', 'name')) {
                $table->dropColumn('name');
            }
            
            // Revert payment_method column
            if (Schema::hasColumn('checkout_orders', 'payment_method')) {
                $table->enum('payment_method', ['midtrans', 'paypal', 'bank_transfer'])->change();
            }
        });
    }
};
