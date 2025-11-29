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
        $clothingCategory = Category::where('name', 'Clothing')->first();
        $homeGoodsCategory = Category::where('name', 'Home Goods')->first();

        $techSupplier = Supplier::where('name', 'Tech Supplies Inc.')->first();
        $bookSupplier = Supplier::where('name', 'Book Distributors LLC')->first();

        DB::table('products')->insert([
            // Electronics
            [
                'name' => 'Laptop Pro 15"',
                'sku' => 'LP-001',
                'barcode' => '1234567890123',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'A powerful laptop for professionals with 15-inch display.',
                'cost_price' => 800.00,
                'selling_price' => 1200.00,
                'reorder_level' => 10,
                'current_stock' => 50,
                'image_path' => null,
            ],
            [
                'name' => 'Wireless Mouse',
                'sku' => 'MOUSE-001',
                'barcode' => '1111111111111',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Ergonomic wireless mouse with precision tracking.',
                'cost_price' => 15.00,
                'selling_price' => 29.99,
                'reorder_level' => 50,
                'current_stock' => 200,
                'image_path' => null,
            ],
            [
                'name' => 'USB-C Hub',
                'sku' => 'HUB-001',
                'barcode' => '2222222222222',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => '7-in-1 USB-C hub with multiple ports.',
                'cost_price' => 25.00,
                'selling_price' => 49.99,
                'reorder_level' => 20,
                'current_stock' => 75,
                'image_path' => null,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'sku' => 'KB-001',
                'barcode' => '3333333333333',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'RGB mechanical keyboard with Blue switches.',
                'cost_price' => 60.00,
                'selling_price' => 129.99,
                'reorder_level' => 15,
                'current_stock' => 45,
                'image_path' => null,
            ],
            [
                'name' => '4K Monitor 27"',
                'sku' => 'MON-001',
                'barcode' => '4444444444444',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => '27-inch 4K UHD monitor for content creators.',
                'cost_price' => 350.00,
                'selling_price' => 599.99,
                'reorder_level' => 5,
                'current_stock' => 20,
                'image_path' => null,
            ],
            [
                'name' => 'Wireless Headphones',
                'sku' => 'HP-001',
                'barcode' => '5555555555555',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Noise-cancelling Bluetooth headphones.',
                'cost_price' => 80.00,
                'selling_price' => 199.99,
                'reorder_level' => 20,
                'current_stock' => 60,
                'image_path' => null,
            ],
            [
                'name' => 'Portable SSD 1TB',
                'sku' => 'SSD-001',
                'barcode' => '6666666666666',
                'category_id' => $electronicsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Fast portable SSD with 1TB storage capacity.',
                'cost_price' => 90.00,
                'selling_price' => 149.99,
                'reorder_level' => 15,
                'current_stock' => 40,
                'image_path' => null,
            ],

            // Books
            [
                'name' => 'The Art of Programming',
                'sku' => 'B-001',
                'barcode' => '9876543210987',
                'category_id' => $booksCategory->id,
                'supplier_id' => $bookSupplier->id,
                'description' => 'A classic book on programming principles.',
                'cost_price' => 20.00,
                'selling_price' => 39.99,
                'reorder_level' => 20,
                'current_stock' => 100,
                'image_path' => null,
            ],
            [
                'name' => 'Clean Code',
                'sku' => 'B-002',
                'barcode' => '1122334455667',
                'category_id' => $booksCategory->id,
                'supplier_id' => $bookSupplier->id,
                'description' => 'How to write maintainable and elegant code.',
                'cost_price' => 22.00,
                'selling_price' => 44.99,
                'reorder_level' => 15,
                'current_stock' => 80,
                'image_path' => null,
            ],
            [
                'name' => 'The Pragmatic Programmer',
                'sku' => 'B-003',
                'barcode' => '2233445566778',
                'category_id' => $booksCategory->id,
                'supplier_id' => $bookSupplier->id,
                'description' => 'Your journey to mastery in software development.',
                'cost_price' => 25.00,
                'selling_price' => 49.99,
                'reorder_level' => 15,
                'current_stock' => 70,
                'image_path' => null,
            ],
            [
                'name' => 'Design Patterns',
                'sku' => 'B-004',
                'barcode' => '3344556677889',
                'category_id' => $booksCategory->id,
                'supplier_id' => $bookSupplier->id,
                'description' => 'Elements of reusable object-oriented software.',
                'cost_price' => 28.00,
                'selling_price' => 59.99,
                'reorder_level' => 10,
                'current_stock' => 50,
                'image_path' => null,
            ],

            // Clothing
            [
                'name' => 'Developer T-Shirt',
                'sku' => 'TSH-001',
                'barcode' => '4455667788990',
                'category_id' => $clothingCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Comfortable cotton t-shirt for developers.',
                'cost_price' => 8.00,
                'selling_price' => 19.99,
                'reorder_level' => 30,
                'current_stock' => 150,
                'image_path' => null,
            ],
            [
                'name' => 'Hoodie Pro',
                'sku' => 'HD-001',
                'barcode' => '5566778899001',
                'category_id' => $clothingCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Premium hoodie with tech branding.',
                'cost_price' => 20.00,
                'selling_price' => 49.99,
                'reorder_level' => 20,
                'current_stock' => 100,
                'image_path' => null,
            ],
            [
                'name' => 'Cargo Pants',
                'sku' => 'PANTS-001',
                'barcode' => '6677889900112',
                'category_id' => $clothingCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Durable cargo pants with multiple pockets.',
                'cost_price' => 25.00,
                'selling_price' => 59.99,
                'reorder_level' => 15,
                'current_stock' => 80,
                'image_path' => null,
            ],

            // Home Goods
            [
                'name' => 'Desk Lamp LED',
                'sku' => 'LAMP-001',
                'barcode' => '7788990011223',
                'category_id' => $homeGoodsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Adjustable LED desk lamp with USB charging.',
                'cost_price' => 18.00,
                'selling_price' => 39.99,
                'reorder_level' => 20,
                'current_stock' => 90,
                'image_path' => null,
            ],
            [
                'name' => 'Ergonomic Chair',
                'sku' => 'CHAIR-001',
                'barcode' => '8899001122334',
                'category_id' => $homeGoodsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Premium ergonomic office chair with lumbar support.',
                'cost_price' => 150.00,
                'selling_price' => 299.99,
                'reorder_level' => 5,
                'current_stock' => 25,
                'image_path' => null,
            ],
            [
                'name' => 'Standing Desk',
                'sku' => 'DESK-001',
                'barcode' => '9900112233445',
                'category_id' => $homeGoodsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Electric adjustable standing desk.',
                'cost_price' => 200.00,
                'selling_price' => 499.99,
                'reorder_level' => 3,
                'current_stock' => 15,
                'image_path' => null,
            ],
            [
                'name' => 'Desk Organizer',
                'sku' => 'ORG-001',
                'barcode' => '0011223344556',
                'category_id' => $homeGoodsCategory->id,
                'supplier_id' => $techSupplier->id,
                'description' => 'Bamboo desk organizer with multiple compartments.',
                'cost_price' => 12.00,
                'selling_price' => 24.99,
                'reorder_level' => 25,
                'current_stock' => 120,
                'image_path' => null,
            ],
        ]);
    }
}
