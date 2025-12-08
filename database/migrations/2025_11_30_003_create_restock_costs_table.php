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
        Schema::create('restock_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->enum('cost_type', ['tax', 'shipping', 'labor', 'other']);
            $table->string('label', 100)->comment('e.g., VAT, Gas, Handling');
            $table->decimal('amount', 15, 2);
            $table->boolean('is_percentage')->default(false)->comment('For tax: 15% vs 200 pesos');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index(['inventory_id', 'cost_type']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_costs');
    }
};
