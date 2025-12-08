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
        // Add restock_id to stock_movements table to link fulfillments to restock plans
        Schema::table('stock_movements', function (Blueprint $table) {
            if (!Schema::hasColumn('stock_movements', 'restock_id')) {
                $table->foreignId('restock_id')->nullable()->constrained('restocks')->cascadeOnDelete();
                $table->index('restock_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            if (Schema::hasColumn('stock_movements', 'restock_id')) {
                $table->dropForeign(['restock_id']);
                $table->dropColumn('restock_id');
            }
        });
    }
};
