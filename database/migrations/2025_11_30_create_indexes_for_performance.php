<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Create indexes for faster queries and joins
     */
    public function up(): void
    {
        // Users table indexes
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('userid');
                $table->index('email');
                $table->index('is_admin');
            });
        }

        // Inventories table indexes
        if (Schema::hasTable('inventories')) {
            Schema::table('inventories', function (Blueprint $table) {
                $table->index('name');
                $table->index('status');
            });
        }

        // Categories table indexes
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->index('inventory_id');
                $table->index('name');
                $table->index(['inventory_id', 'name']);
            });
        }

        // Suppliers table indexes
        if (Schema::hasTable('suppliers')) {
            Schema::table('suppliers', function (Blueprint $table) {
                $table->index('inventory_id');
                $table->index('name');
                $table->index('email');
                $table->index(['inventory_id', 'name']);
            });
        }

        // Products table indexes - Most critical for queries
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index('inventory_id');
                $table->index('category_id');
                $table->index('supplier_id');
                $table->index('sku');
                $table->index('barcode');
                $table->index('name');
                $table->index('current_stock');
                $table->index('reorder_level');
                // Composite indexes for common queries
                $table->index(['inventory_id', 'category_id']);
                $table->index(['inventory_id', 'supplier_id']);
                $table->index(['inventory_id', 'current_stock']);
                $table->index(['inventory_id', 'reorder_level']);
            });
        }

        // Stock Movements table indexes - Only product_id, type, created_at (no inventory_id)
        if (Schema::hasTable('stock_movements')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->index('product_id');
                $table->index('type');
                $table->index('created_at');
                $table->index(['product_id', 'created_at']);
            });
        }

        // Alerts table indexes - Only product_id, type, status (no inventory_id)
        if (Schema::hasTable('alerts')) {
            Schema::table('alerts', function (Blueprint $table) {
                $table->index('product_id');
                $table->index('type');
                $table->index('status');
            });
        }

        // User Inventories table indexes - Critical for access control
        if (Schema::hasTable('user_inventories')) {
            Schema::table('user_inventories', function (Blueprint $table) {
                $table->index('user_id');
                $table->index('inventory_id');
                $table->index(['user_id', 'inventory_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop all indexes safely
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['userid']);
                $table->dropIndex(['email']);
                $table->dropIndex(['is_admin']);
            });
        }

        if (Schema::hasTable('inventories')) {
            Schema::table('inventories', function (Blueprint $table) {
                $table->dropIndex(['name']);
                $table->dropIndex(['status']);
            });
        }

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropIndex(['inventory_id']);
                $table->dropIndex(['name']);
                $table->dropIndex(['inventory_id', 'name']);
            });
        }

        if (Schema::hasTable('suppliers')) {
            Schema::table('suppliers', function (Blueprint $table) {
                $table->dropIndex(['inventory_id']);
                $table->dropIndex(['name']);
                $table->dropIndex(['email']);
                $table->dropIndex(['inventory_id', 'name']);
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropIndex(['inventory_id']);
                $table->dropIndex(['category_id']);
                $table->dropIndex(['supplier_id']);
                $table->dropIndex(['sku']);
                $table->dropIndex(['barcode']);
                $table->dropIndex(['name']);
                $table->dropIndex(['current_stock']);
                $table->dropIndex(['reorder_level']);
                $table->dropIndex(['inventory_id', 'category_id']);
                $table->dropIndex(['inventory_id', 'supplier_id']);
                $table->dropIndex(['inventory_id', 'current_stock']);
                $table->dropIndex(['inventory_id', 'reorder_level']);
            });
        }

        if (Schema::hasTable('stock_movements')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->dropIndex(['product_id']);
                $table->dropIndex(['type']);
                $table->dropIndex(['created_at']);
                $table->dropIndex(['product_id', 'created_at']);
            });
        }

        if (Schema::hasTable('alerts')) {
            Schema::table('alerts', function (Blueprint $table) {
                $table->dropIndex(['product_id']);
                $table->dropIndex(['type']);
                $table->dropIndex(['status']);
            });
        }

        if (Schema::hasTable('user_inventories')) {
            Schema::table('user_inventories', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
                $table->dropIndex(['inventory_id']);
                $table->dropIndex(['user_id', 'inventory_id']);
            });
        }
    }
};
