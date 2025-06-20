<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add check constraint to ensure stock_quantity is not negative
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_stock_positive CHECK (stock_quantity >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the constraint
        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS chk_stock_positive');
    }
};
