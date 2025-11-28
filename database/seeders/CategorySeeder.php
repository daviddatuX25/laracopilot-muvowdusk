<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories.'],
            ['name' => 'Books', 'description' => 'Printed and electronic books.'],
            ['name' => 'Clothing', 'description' => 'Apparel and accessories.'],
            ['name' => 'Home Goods', 'description' => 'Items for home and kitchen.'],
        ]);
    }
}
