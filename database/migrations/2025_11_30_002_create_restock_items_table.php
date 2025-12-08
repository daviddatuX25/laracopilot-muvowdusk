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
        Schema::create('restock_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restock_id')->constrained('restocks')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            $table->integer('quantity_requested');
            $table->decimal('unit_cost', 15, 2);
            $table->decimal('subtotal', 15, 2)->comment('quantity * unit_cost');

            $table->timestamps();

            // Indexes
            $table->unique(['restock_id', 'product_id']);
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_items');
    }
};
