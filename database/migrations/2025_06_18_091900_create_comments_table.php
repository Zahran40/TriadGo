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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('comment_id');
            
            // Foreign Keys
            $table->unsignedBigInteger('product_id'); // FK ke products table
            $table->unsignedBigInteger('user_id'); // FK ke users table (pemberi komentar)
            
            // Comment Data
            $table->text('comment_text');
            $table->integer('rating')->default(5); // Rating 1-5 stars
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Key Constraints
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index('product_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};