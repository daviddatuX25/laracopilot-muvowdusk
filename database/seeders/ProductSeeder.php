<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronicsCategory = Category::where('name', 'Electronics')->first();
        $booksCategory = Category::where('name', 'Books')->first();
        $techSupplier = Supplier::where('name', 'Tech Supplies Inc.')->first();
        $bookSupplier = Supplier::where('name', 'Book Distributors LLC')->first();

        DB::table('products')->insert([
            [
                'name' => 'Laptop Pro',
                'sku' => 'LP-001',
                'barcode' => '1234567890123',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'A powerful laptop for professionals.',
                'cost_price' => 800.00,
                'selling_price' => 1200.00,
                'reorder_level' => 10,
                'current_stock' => 50,
                'image_path' => null,
            ],
            [
                'name' => 'The Art of Programming',
                'sku' => 'B-001',
                'barcode' => '9876543210987',
                'category_id' => $booksCategory->id,
                'supplier_id' => $bookSupplier->id,
                'description' => 'A classic book on programming.',
                'cost_price' => 20.00,
                'selling_price' => 39.99,
                'reorder_level' => 20,
                'current_stock' => 100,
                'image_path' => null,
            ],
        ]);
    }
}
