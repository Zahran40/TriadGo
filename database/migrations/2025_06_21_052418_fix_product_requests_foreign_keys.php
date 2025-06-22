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
        Schema::table('product_requests', function (Blueprint $table) {
            // Drop existing foreign key constraints if they exist
            try {
                $table->dropForeign(['importir_user_id']);
                $table->dropForeign(['eksportir_user_id']);
                $table->dropForeign(['product_id']);
            } catch (Exception $e) {
                // Ignore if foreign keys don't exist
            }
            
            // Add correct foreign key constraints
            $table->foreign('importir_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('eksportir_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropForeign(['importir_user_id']);
            $table->dropForeign(['eksportir_user_id']);
            $table->dropForeign(['product_id']);
        });
    }
};
