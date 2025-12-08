<?php

namespace Database\Seeders;

use App\Models\Restock;
use App\Models\RestockItem;
use App\Models\RestockCost;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class RestockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample restock cost templates
        $inventories = Inventory::all();
        $users = User::all();

        foreach ($inventories as $inventory) {
            foreach ($users as $user) {
                // Create common cost templates
                RestockCost::create([
                    'inventory_id' => $inventory->id,
                    'user_id' => $user->id,
                    'cost_type' => 'tax',
                    'label' => 'VAT',
                    'amount' => 15,
                    'is_percentage' => true,
                    'is_active' => true,
                ]);

                RestockCost::create([
                    'inventory_id' => $inventory->id,
                    'user_id' => $user->id,
                    'cost_type' => 'shipping',
                    'label' => 'Gas',
                    'amount' => 50,
                    'is_percentage' => false,
                    'is_active' => true,
                ]);

                RestockCost::create([
                    'inventory_id' => $inventory->id,
                    'user_id' => $user->id,
                    'cost_type' => 'labor',
                    'label' => 'Handling',
                    'amount' => 25,
                    'is_percentage' => false,
                    'is_active' => true,
                ]);

                // Create sample restock plans
                $products = $inventory->products()->limit(5)->get();

                if ($products->count() > 0) {
                    // Create a draft plan
                    $draftRestock = Restock::create([
                        'inventory_id' => $inventory->id,
                        'user_id' => $user->id,
                        'status' => 'draft',
                        'budget_amount' => 5000,
                        'cart_total' => 3000,
                        'tax_percentage' => 15,
                        'tax_amount' => 450,
                        'shipping_fee' => 100,
                        'labor_fee' => 0,
                        'other_fees' => [],
                        'total_cost' => 3550,
                        'budget_status' => 'under',
                        'budget_difference' => 1450,
                        'notes' => 'Monthly restock - draft',
                    ]);

                    // Add items
                    foreach ($products as $index => $product) {
                        RestockItem::create([
                            'restock_id' => $draftRestock->id,
                            'product_id' => $product->id,
                            'quantity_requested' => 10 + ($index * 5),
                            'unit_cost' => $product->cost_price,
                            'subtotal' => (10 + ($index * 5)) * $product->cost_price,
                        ]);
                    }

                    // Create a fulfilled plan
                    $fulfilledRestock = Restock::create([
                        'inventory_id' => $inventory->id,
                        'user_id' => $user->id,
                        'status' => 'fulfilled',
                        'budget_amount' => 4000,
                        'cart_total' => 2500,
                        'tax_percentage' => 15,
                        'tax_amount' => 375,
                        'shipping_fee' => 100,
                        'labor_fee' => 25,
                        'other_fees' => [],
                        'total_cost' => 3000,
                        'budget_status' => 'under',
                        'budget_difference' => 1000,
                        'notes' => 'Monthly restock - completed',
                        'fulfilled_at' => now()->subDays(5),
                        'fulfilled_by' => $user->id,
                    ]);

                    // Add items
                    foreach ($products as $index => $product) {
                        RestockItem::create([
                            'restock_id' => $fulfilledRestock->id,
                            'product_id' => $product->id,
                            'quantity_requested' => 5 + ($index * 3),
                            'unit_cost' => $product->cost_price,
                            'subtotal' => (5 + ($index * 3)) * $product->cost_price,
                        ]);
                    }
                }
            }
        }
    }
}
