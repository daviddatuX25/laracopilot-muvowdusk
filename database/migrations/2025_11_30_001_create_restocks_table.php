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
        Schema::create('restocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->enum('status', ['draft', 'pending', 'fulfilled', 'cancelled'])->default('draft');

            // Budget tracking
            $table->decimal('budget_amount', 15, 2);
            $table->decimal('cart_total', 15, 2)->default(0);

            // Cost breakdown
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('shipping_fee', 15, 2)->default(0);
            $table->decimal('labor_fee', 15, 2)->default(0);
            $table->json('other_fees')->nullable()->comment('Array of {label, amount}');

            // Total and budget status
            $table->decimal('total_cost', 15, 2);
            $table->enum('budget_status', ['under', 'fit', 'over'])->default('fit');
            $table->decimal('budget_difference', 15, 2)->nullable()->comment('Positive if under, negative if over');

            // Additional fields
            $table->text('notes')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->foreignId('fulfilled_by')->nullable()->constrained('users')->cascadeOnDelete();

            $table->timestamps();

            // Indexes
            $table->index('inventory_id');
            $table->index('user_id');
            $table->index('status');
            $table->index(['inventory_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restocks');
    }
};
