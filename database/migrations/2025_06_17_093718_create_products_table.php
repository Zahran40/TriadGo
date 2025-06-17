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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            
            // Foreign Key ke Users (Many-to-One)
            $table->unsignedBigInteger('user_id'); // FK ke users table
            
            // Product Information dari Form Eksportir
            $table->string('product_name');
            $table->text('product_description');
            $table->string('category');
            $table->decimal('price', 10, 2); // 99999999.99 max
            $table->integer('stock_quantity');
            $table->string('product_sku')->unique(); // Product ID/SKU
            $table->decimal('weight', 8, 2); // Weight in kg
            $table->string('country_of_origin');
            $table->string('product_image')->nullable(); // Path to uploaded image
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Key Constraint
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index('user_id');
            $table->index('category');
            $table->unique('product_sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};