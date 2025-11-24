<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $stats = [
            'total_products' => 1250,
            'total_orders' => 872,
            'total_customers' => 438,
            'total_revenue' => '$125,432',
            'pending_orders' => 42,
            'new_customers' => 18
        ];

        $recentOrders = [
            ['id' => 1001, 'customer' => 'John Doe', 'date' => '2023-11-15', 'amount' => '$125.00', 'status' => 'Completed'],
            ['id' => 1002, 'customer' => 'Jane Smith', 'date' => '2023-11-16', 'amount' => '$89.99', 'status' => 'Processing'],
            ['id' => 1003, 'customer' => 'Robert Johnson', 'date' => '2023-11-17', 'amount' => '$245.50', 'status' => 'Shipped'],
            ['id' => 1004, 'customer' => 'Emily Davis', 'date' => '2023-11-18', 'amount' => '$59.99', 'status' => 'Completed'],
            ['id' => 1005, 'customer' => 'Michael Wilson', 'date' => '2023-11-19', 'amount' => '$175.25', 'status' => 'Pending']
        ];

        $topProducts = [
            ['name' => 'Premium Widget', 'sales' => 325, 'revenue' => '$45,250'],
            ['name' => 'Basic Gadget', 'sales' => 287, 'revenue' => '$32,145'],
            ['name' => 'Deluxe Tool', 'sales' => 198, 'revenue' => '$28,710'],
            ['name' => 'Standard Kit', 'sales' => 142, 'revenue' => '$19,875'],
            ['name' => 'Pro Accessory', 'sales' => 95, 'revenue' => '$13,250']
        ];

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }

    public function products()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $products = [
            ['id' => 1, 'name' => 'Premium Widget', 'category' => 'Widgets', 'price' => '$25.00', 'stock' => 50, 'sales' => 325],
            ['id' => 2, 'name' => 'Basic Gadget', 'category' => 'Gadgets', 'price' => '$19.99', 'stock' => 75, 'sales' => 287],
            ['id' => 3, 'name' => 'Deluxe Tool', 'category' => 'Tools', 'price' => '$45.50', 'stock' => 30, 'sales' => 198],
            ['id' => 4, 'name' => 'Standard Kit', 'category' => 'Kits', 'price' => '$29.99', 'stock' => 45, 'sales' => 142],
            ['id' => 5, 'name' => 'Pro Accessory', 'category' => 'Accessories', 'price' => '$35.00', 'stock' => 20, 'sales' => 95],
            ['id' => 6, 'name' => 'Basic Widget', 'category' => 'Widgets', 'price' => '$15.00', 'stock' => 100, 'sales' => 210],
            ['id' => 7, 'name' => 'Standard Gadget', 'category' => 'Gadgets', 'price' => '$24.99', 'stock' => 60, 'sales' => 185],
            ['id' => 8, 'name' => 'Basic Tool', 'category' => 'Tools', 'price' => '$39.99', 'stock' => 40, 'sales' => 120],
            ['id' => 9, 'name' => 'Deluxe Kit', 'category' => 'Kits', 'price' => '$59.99', 'stock' => 25, 'sales' => 85],
            ['id' => 10, 'name' => 'Premium Accessory', 'category' => 'Accessories', 'price' => '$45.00', 'stock' => 15, 'sales' => 60]
        ];

        return view('admin.products', compact('products'));
    }

    public function orders()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $orders = [
            ['id' => 1001, 'customer' => 'John Doe', 'date' => '2023-11-15', 'amount' => '$125.00', 'status' => 'Completed'],
            ['id' => 1002, 'customer' => 'Jane Smith', 'date' => '2023-11-16', 'amount' => '$89.99', 'status' => 'Processing'],
            ['id' => 1003, 'customer' => 'Robert Johnson', 'date' => '2023-11-17', 'amount' => '$245.50', 'status' => 'Shipped'],
            ['id' => 1004, 'customer' => 'Emily Davis', 'date' => '2023-11-18', 'amount' => '$59.99', 'status' => 'Completed'],
            ['id' => 1005, 'customer' => 'Michael Wilson', 'date' => '2023-11-19', 'amount' => '$175.25', 'status' => 'Pending'],
            ['id' => 1006, 'customer' => 'Sarah Brown', 'date' => '2023-11-20', 'amount' => '$99.99', 'status' => 'Completed'],
            ['id' => 1007, 'customer' => 'David Taylor', 'date' => '2023-11-21', 'amount' => '$149.50', 'status' => 'Processing'],
            ['id' => 1008, 'customer' => 'Jessica Anderson', 'date' => '2023-11-22', 'amount' => '$215.00', 'status' => 'Shipped'],
            ['id' => 1009, 'customer' => 'Thomas Martinez', 'date' => '2023-11-23', 'amount' => '$75.00', 'status' => 'Completed'],
            ['id' => 1010, 'customer' => 'Lisa Robinson', 'date' => '2023-11-24', 'amount' => '$199.99', 'status' => 'Pending']
        ];

        return view('admin.orders', compact('orders'));
    }

    public function customers()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $customers = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'phone' => '(555) 123-4567', 'orders' => 5, 'total_spent' => '$245.00'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'phone' => '(555) 234-5678', 'orders' => 3, 'total_spent' => '$189.97'],
            ['id' => 3, 'name' => 'Robert Johnson', 'email' => 'robert.johnson@example.com', 'phone' => '(555) 345-6789', 'orders' => 4, 'total_spent' => '$345.50'],
            ['id' => 4, 'name' => 'Emily Davis', 'email' => 'emily.davis@example.com', 'phone' => '(555) 456-7890', 'orders' => 2, 'total_spent' => '$59.99'],
            ['id' => 5, 'name' => 'Michael Wilson', 'email' => 'michael.wilson@example.com', 'phone' => '(555) 567-8901', 'orders' => 1, 'total_spent' => '$175.25'],
            ['id' => 6, 'name' => 'Sarah Brown', 'email' => 'sarah.brown@example.com', 'phone' => '(555) 678-9012', 'orders' => 3, 'total_spent' => '$99.99'],
            ['id' => 7, 'name' => 'David Taylor', 'email' => 'david.taylor@example.com', 'phone' => '(555) 789-0123', 'orders' => 2, 'total_spent' => '$149.50'],
            ['id' => 8, 'name' => 'Jessica Anderson', 'email' => 'jessica.anderson@example.com', 'phone' => '(555) 890-1234', 'orders' => 4, 'total_spent' => '$215.00'],
            ['id' => 9, 'name' => 'Thomas Martinez', 'email' => 'thomas.martinez@example.com', 'phone' => '(555) 901-2345', 'orders' => 1, 'total_spent' => '$75.00'],
            ['id' => 10, 'name' => 'Lisa Robinson', 'email' => 'lisa.robinson@example.com', 'phone' => '(555) 012-3456', 'orders' => 2, 'total_spent' => '$199.99']
        ];

        return view('admin.customers', compact('customers'));
    }

    public function settings()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $settings = [
            'site_name' => 'Business Admin Panel',
            'site_email' => 'admin@business.com',
            'currency' => 'USD',
            'timezone' => 'America/New_York',
            'date_format' => 'MM/DD/YYYY',
            'time_format' => '12-hour',
            'pagination' => 10,
            'maintenance_mode' => false,
            'notifications' => [
                'new_order' => true,
                'low_stock' => true,
                'system_alerts' => true
            ]
        ];

        return view('admin.settings', compact('settings'));
    }

    public function reports()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $reports = [
            'sales' => [
                'title' => 'Sales Report',
                'description' => 'Overview of sales performance',
                'data' => [
                    ['month' => 'January', 'sales' => 12500],
                    ['month' => 'February', 'sales' => 15200],
                    ['month' => 'March', 'sales' => 18750],
                    ['month' => 'April', 'sales' => 21000],
                    ['month' => 'May', 'sales' => 24500],
                    ['month' => 'June', 'sales' => 27800]
                ]
            ],
            'customers' => [
                'title' => 'Customer Growth',
                'description' => 'New customer acquisition trends',
                'data' => [
                    ['month' => 'January', 'customers' => 120],
                    ['month' => 'February', 'customers' => 155],
                    ['month' => 'March', 'customers' => 180],
                    ['month' => 'April', 'customers' => 210],
                    ['month' => 'May', 'customers' => 245],
                    ['month' => 'June', 'customers' => 280]
                ]
            ],
            'products' => [
                'title' => 'Top Products',
                'description' => 'Best-selling products',
                'data' => [
                    ['product' => 'Premium Widget', 'sales' => 325],
                    ['product' => 'Basic Gadget', 'sales' => 287],
                    ['product' => 'Deluxe Tool', 'sales' => 198],
                    ['product' => 'Standard Kit', 'sales' => 142],
                    ['product' => 'Pro Accessory', 'sales' => 95]
                ]
            ]
        ];

        return view('admin.reports', compact('reports'));
    }
}