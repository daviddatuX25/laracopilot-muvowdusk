<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Inventory;
use App\Models\UserInventory;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // CREATE USERS
        // ============================================

        // Instructor Zeus - Admin
        $zeus = User::create([
            'userid' => 'zues',
            'name' => 'Zeus Instructor',
            'email' => 'zeus@inventory.local',
            'password' => Hash::make('zues123'),
            'is_admin' => false,
        ]);

        // Instructor Zeus - Admin Account
        $zeusAdmin = User::create([
            'userid' => 'zuesadmin',
            'name' => 'Zeus Admin',
            'email' => 'zuesadmin@inventory.local',
            'password' => Hash::make('zuesadmin123'),
            'is_admin' => true,
        ]);

        // Super Admin - For Development
        $superAdmin = User::create([
            'userid' => 'superadmin',
            'name' => 'Super Administrator',
            'email' => 'superadmin@inventory.local',
            'password' => Hash::make('spidyweb123'),
            'is_admin' => true,
        ]);

        // Regular User
        $regularUser = User::create([
            'userid' => 'user',
            'name' => 'Regular User',
            'email' => 'user@inventory.local',
            'password' => Hash::make('user123'),
            'is_admin' => false,
        ]);

        // ============================================
        // CREATE INVENTORIES FOR ZEUS
        // ============================================

        // Zeus Inventory 1 - Furniture Store
        $zesFurniture = Inventory::create([
            'name' => 'Zeus Furniture Store',
            'description' => 'Furniture retail and wholesale inventory',
            'location' => 'Downtown Branch',
            'status' => 'active',
        ]);

        // Zeus Inventory 2 - Sari-Sari Store
        $zesSariSari = Inventory::create([
            'name' => 'Zeus Sari-Sari Store',
            'description' => 'General merchandise and convenience store',
            'location' => 'Residential Area',
            'status' => 'active',
        ]);

        // ============================================
        // CREATE INVENTORY FOR REGULAR USER
        // ============================================

        // User Inventory - Electronics Shop
        $userElectronics = Inventory::create([
            'name' => 'Electronics Shop',
            'description' => 'Electronic devices and accessories',
            'location' => 'Tech Mall',
            'status' => 'active',
        ]);

        // ============================================
        // ASSIGN USERS TO INVENTORIES
        // ============================================

        // Zeus has access to both his inventories
        UserInventory::create(['user_id' => $zeus->id, 'inventory_id' => $zesFurniture->id]);
        UserInventory::create(['user_id' => $zeus->id, 'inventory_id' => $zesSariSari->id]);

        // Zeus Admin has access to both Zeus inventories
        UserInventory::create(['user_id' => $zeusAdmin->id, 'inventory_id' => $zesFurniture->id]);
        UserInventory::create(['user_id' => $zeusAdmin->id, 'inventory_id' => $zesSariSari->id]);

        // Super Admin has access to all inventories
        UserInventory::create(['user_id' => $superAdmin->id, 'inventory_id' => $zesFurniture->id]);
        UserInventory::create(['user_id' => $superAdmin->id, 'inventory_id' => $zesSariSari->id]);
        UserInventory::create(['user_id' => $superAdmin->id, 'inventory_id' => $userElectronics->id]);

        // Regular user has access to electronics shop
        UserInventory::create(['user_id' => $regularUser->id, 'inventory_id' => $userElectronics->id]);

        // ============================================
        // SEED FURNITURE STORE DATA
        // ============================================

        // Furniture Categories
        $furnitureCategories = [
            Category::create(['name' => 'Living Room', 'description' => 'Sofas, chairs, tables', 'inventory_id' => $zesFurniture->id]),
            Category::create(['name' => 'Bedroom', 'description' => 'Beds, nightstands, dressers', 'inventory_id' => $zesFurniture->id]),
            Category::create(['name' => 'Dining', 'description' => 'Dining tables and chairs', 'inventory_id' => $zesFurniture->id]),
            Category::create(['name' => 'Office', 'description' => 'Desks and office furniture', 'inventory_id' => $zesFurniture->id]),
        ];

        // Furniture Suppliers
        $furnitureSuppliers = [
            Supplier::create([
                'name' => 'Modern Furniture Co.',
                'contact_person' => 'John Smith',
                'email' => 'contact@modernfurn.com',
                'phone' => '555-0101',
                'address' => '123 Furniture St, NY',
                'inventory_id' => $zesFurniture->id,
            ]),
            Supplier::create([
                'name' => 'Classic Designs Ltd.',
                'contact_person' => 'Maria Garcia',
                'email' => 'sales@classicdesigns.com',
                'phone' => '555-0102',
                'address' => '456 Design Ave, LA',
                'inventory_id' => $zesFurniture->id,
            ]),
        ];

        // Furniture Products
        $furnitureProducts = [
            ['name' => 'Leather Sofa', 'sku' => 'FUR-001', 'category' => 0, 'supplier' => 0, 'cost' => 300, 'sell' => 500, 'stock' => 15],
            ['name' => 'Wooden Dining Table', 'sku' => 'FUR-002', 'category' => 2, 'supplier' => 0, 'cost' => 200, 'sell' => 350, 'stock' => 8],
            ['name' => 'Queen Size Bed', 'sku' => 'FUR-003', 'category' => 1, 'supplier' => 1, 'cost' => 400, 'sell' => 700, 'stock' => 12],
            ['name' => 'Office Chair', 'sku' => 'FUR-004', 'category' => 3, 'supplier' => 1, 'cost' => 150, 'sell' => 250, 'stock' => 20],
            ['name' => 'Coffee Table', 'sku' => 'FUR-005', 'category' => 0, 'supplier' => 0, 'cost' => 100, 'sell' => 180, 'stock' => 25],
            ['name' => 'Nightstand', 'sku' => 'FUR-006', 'category' => 1, 'supplier' => 1, 'cost' => 80, 'sell' => 140, 'stock' => 30],
            ['name' => 'Bookshelf', 'sku' => 'FUR-007', 'category' => 3, 'supplier' => 0, 'cost' => 120, 'sell' => 220, 'stock' => 18],
            ['name' => 'Accent Chair', 'sku' => 'FUR-008', 'category' => 0, 'supplier' => 1, 'cost' => 180, 'sell' => 320, 'stock' => 22],
        ];

        foreach ($furnitureProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'sku' => $product['sku'],
                'barcode' => 'BC-' . $product['sku'],
                'category_id' => $furnitureCategories[$product['category']]->id,
                'supplier_id' => $furnitureSuppliers[$product['supplier']]->id,
                'inventory_id' => $zesFurniture->id,
                'description' => 'High quality ' . strtolower($product['name']),
                'cost_price' => $product['cost'],
                'selling_price' => $product['sell'],
                'reorder_level' => 5,
                'current_stock' => $product['stock'],
            ]);
        }

        // ============================================
        // SEED SARI-SARI STORE DATA
        // ============================================

        // Sari-Sari Categories
        $sariSariCategories = [
            Category::create(['name' => 'Groceries', 'description' => 'Food and beverage items', 'inventory_id' => $zesSariSari->id]),
            Category::create(['name' => 'Snacks', 'description' => 'Chips, cookies, candies', 'inventory_id' => $zesSariSari->id]),
            Category::create(['name' => 'Beverages', 'description' => 'Drinks and juices', 'inventory_id' => $zesSariSari->id]),
            Category::create(['name' => 'Personal Care', 'description' => 'Toiletries and hygiene', 'inventory_id' => $zesSariSari->id]),
            Category::create(['name' => 'Household', 'description' => 'Cleaning and household items', 'inventory_id' => $zesSariSari->id]),
        ];

        // Sari-Sari Suppliers
        $sariSariSuppliers = [
            Supplier::create([
                'name' => 'Metro Wholesale',
                'contact_person' => 'Miguel Santos',
                'email' => 'bulk@metrosp.com',
                'phone' => '555-0201',
                'address' => '789 Commercial Blvd, Manila',
                'inventory_id' => $zesSariSari->id,
            ]),
            Supplier::create([
                'name' => 'Local Distributor Inc.',
                'contact_person' => 'Rosa Cruz',
                'email' => 'sales@localdistr.com',
                'phone' => '555-0202',
                'address' => '321 Trade St, Quezon City',
                'inventory_id' => $zesSariSari->id,
            ]),
        ];

        // Sari-Sari Products
        $sariSariProducts = [
            ['name' => 'Rice (5kg)', 'sku' => 'GRO-001', 'category' => 0, 'supplier' => 0, 'cost' => 12, 'sell' => 20, 'stock' => 100],
            ['name' => 'Cooking Oil (1L)', 'sku' => 'GRO-002', 'category' => 0, 'supplier' => 0, 'cost' => 8, 'sell' => 14, 'stock' => 80],
            ['name' => 'Instant Noodles (Pack)', 'sku' => 'SNK-001', 'category' => 1, 'supplier' => 1, 'cost' => 0.50, 'sell' => 1.50, 'stock' => 500],
            ['name' => 'Biscuits (Pack)', 'sku' => 'SNK-002', 'category' => 1, 'supplier' => 1, 'cost' => 2, 'sell' => 4, 'stock' => 200],
            ['name' => 'Coffee Mix (25 pcs)', 'sku' => 'BEV-001', 'category' => 2, 'supplier' => 0, 'cost' => 3, 'sell' => 6, 'stock' => 150],
            ['name' => 'Juice Drink (1L)', 'sku' => 'BEV-002', 'category' => 2, 'supplier' => 1, 'cost' => 2.50, 'sell' => 5, 'stock' => 120],
            ['name' => 'Soap Bar', 'sku' => 'PER-001', 'category' => 3, 'supplier' => 0, 'cost' => 1, 'sell' => 2, 'stock' => 300],
            ['name' => 'Toothpaste (120g)', 'sku' => 'PER-002', 'category' => 3, 'supplier' => 1, 'cost' => 2.50, 'sell' => 5, 'stock' => 100],
            ['name' => 'Dishwashing Liquid (1L)', 'sku' => 'HOU-001', 'category' => 4, 'supplier' => 0, 'cost' => 2, 'sell' => 4, 'stock' => 80],
            ['name' => 'Floor Cleaner (500ml)', 'sku' => 'HOU-002', 'category' => 4, 'supplier' => 1, 'cost' => 1.50, 'sell' => 3, 'stock' => 120],
        ];

        foreach ($sariSariProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'sku' => $product['sku'],
                'barcode' => 'BC-' . $product['sku'],
                'category_id' => $sariSariCategories[$product['category']]->id,
                'supplier_id' => $sariSariSuppliers[$product['supplier']]->id,
                'inventory_id' => $zesSariSari->id,
                'description' => 'Quality ' . strtolower($product['name']),
                'cost_price' => $product['cost'],
                'selling_price' => $product['sell'],
                'reorder_level' => 10,
                'current_stock' => $product['stock'],
            ]);
        }

        // ============================================
        // SEED ELECTRONICS SHOP DATA
        // ============================================

        // Electronics Categories
        $electronicsCategories = [
            Category::create(['name' => 'Smartphones', 'description' => 'Mobile phones and accessories', 'inventory_id' => $userElectronics->id]),
            Category::create(['name' => 'Laptops', 'description' => 'Computers and tablets', 'inventory_id' => $userElectronics->id]),
            Category::create(['name' => 'Accessories', 'description' => 'Chargers, cables, adapters', 'inventory_id' => $userElectronics->id]),
            Category::create(['name' => 'Audio', 'description' => 'Headphones and speakers', 'inventory_id' => $userElectronics->id]),
        ];

        // Electronics Suppliers
        $electronicsSuppliers = [
            Supplier::create([
                'name' => 'TechHub Distributors',
                'contact_person' => 'Alex Chen',
                'email' => 'bulk@techhub.com',
                'phone' => '555-0301',
                'address' => '100 Tech Park, Silicon Valley',
                'inventory_id' => $userElectronics->id,
            ]),
            Supplier::create([
                'name' => 'ElectroWorld Ltd.',
                'contact_person' => 'Sarah Johnson',
                'email' => 'wholesale@electroworld.com',
                'phone' => '555-0302',
                'address' => '200 Digital Ave, San Francisco',
                'inventory_id' => $userElectronics->id,
            ]),
        ];

        // Electronics Products
        $electronicsProducts = [
            ['name' => 'Smartphone X Pro', 'sku' => 'PHO-001', 'category' => 0, 'supplier' => 0, 'cost' => 400, 'sell' => 700, 'stock' => 20],
            ['name' => 'Smartphone Y Plus', 'sku' => 'PHO-002', 'category' => 0, 'supplier' => 1, 'cost' => 300, 'sell' => 550, 'stock' => 25],
            ['name' => 'Laptop Pro 15', 'sku' => 'LAP-001', 'category' => 1, 'supplier' => 0, 'cost' => 800, 'sell' => 1200, 'stock' => 10],
            ['name' => 'Tablet Z', 'sku' => 'LAP-002', 'category' => 1, 'supplier' => 1, 'cost' => 300, 'sell' => 500, 'stock' => 15],
            ['name' => 'USB-C Cable', 'sku' => 'ACC-001', 'category' => 2, 'supplier' => 0, 'cost' => 3, 'sell' => 8, 'stock' => 200],
            ['name' => 'Charging Adapter', 'sku' => 'ACC-002', 'category' => 2, 'supplier' => 1, 'cost' => 5, 'sell' => 12, 'stock' => 150],
            ['name' => 'Wireless Earbuds', 'sku' => 'AUD-001', 'category' => 3, 'supplier' => 0, 'cost' => 50, 'sell' => 100, 'stock' => 40],
            ['name' => 'Bluetooth Speaker', 'sku' => 'AUD-002', 'category' => 3, 'supplier' => 1, 'cost' => 30, 'sell' => 70, 'stock' => 30],
            ['name' => 'Phone Screen Protector', 'sku' => 'ACC-003', 'category' => 2, 'supplier' => 0, 'cost' => 2, 'sell' => 5, 'stock' => 300],
            ['name' => 'Phone Case', 'sku' => 'ACC-004', 'category' => 2, 'supplier' => 1, 'cost' => 4, 'sell' => 10, 'stock' => 250],
        ];

        foreach ($electronicsProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'sku' => $product['sku'],
                'barcode' => 'BC-' . $product['sku'],
                'category_id' => $electronicsCategories[$product['category']]->id,
                'supplier_id' => $electronicsSuppliers[$product['supplier']]->id,
                'inventory_id' => $userElectronics->id,
                'description' => 'Premium ' . strtolower($product['name']),
                'cost_price' => $product['cost'],
                'selling_price' => $product['sell'],
                'reorder_level' => 3,
                'current_stock' => $product['stock'],
            ]);
        }
    }
}
