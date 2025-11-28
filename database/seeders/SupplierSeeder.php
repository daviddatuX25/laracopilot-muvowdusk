<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'name' => 'Tech Supplies Inc.',
                'contact_person' => 'John Doe',
                'email' => 'john.doe@techsupplies.com',
                'phone' => '123-456-7890',
                'address' => '123 Tech Street, Silicon Valley, CA'
            ],
            [
                'name' => 'Book Distributors LLC',
                'contact_person' => 'Jane Smith',
                'email' => 'jane.smith@bookdist.com',
                'phone' => '098-765-4321',
                'address' => '456 Book Avenue, New York, NY'
            ],
        ]);
    }
}
