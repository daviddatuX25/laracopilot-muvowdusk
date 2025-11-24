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
            'total_users' => 1245,
            'active_subscriptions' => 872,
            'monthly_revenue' => '$45,230',
            'pending_orders' => 42
        ];

        $recentActivity = [
            ['user' => 'John Doe', 'action' => 'Created new product', 'time' => '2 hours ago'],
            ['user' => 'Jane Smith', 'action' => 'Updated order status', 'time' => '5 hours ago'],
            ['user' => 'Mike Johnson', 'action' => 'Added new customer', 'time' => '1 day ago'],
            ['user' => 'Sarah Williams', 'action' => 'Generated report', 'time' => '2 days ago']
        ];

        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [12000, 15000, 18000, 22000, 25000, 30000],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'borderWidth' => 2
                ]
            ]
        ];

        return view('admin.dashboard', compact('stats', 'recentActivity', 'chartData'));
    }

    public function products()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $products = [
            [
                'id' => 1,
                'name' => 'Premium Cloud Package',
                'category' => 'Cloud Solutions',
                'price' => '$99/month',
                'status' => 'Active',
                'stock' => 100
            ],
            [
                'id' => 2,
                'name' => 'Advanced Analytics Suite',
                'category' => 'Data Analytics',
                'price' => '$149/month',
                'status' => 'Active',
                'stock' => 50
            ],
            [
                'id' => 3,
                'name' => 'Enterprise Security Bundle',
                'category' => 'Cybersecurity',
                'price' => '$199/month',
                'status' => 'Active',
                'stock' => 75
            ],
            [
                'id' => 4,
                'name' => 'Basic Cloud Package',
                'category' => 'Cloud Solutions',
                'price' => '$49/month',
                'status' => 'Active',
                'stock' => 200
            ],
            [
                'id' => 5,
                'name' => 'Standard Analytics Package',
                'category' => 'Data Analytics',
                'price' => '$79/month',
                'status' => 'Active',
                'stock' => 120
            ]
        ];

        return view('admin.products', compact('products'));
    }

    public function orders()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $orders = [
            [
                'id' => 1001,
                'customer' => 'John Doe',
                'product' => 'Premium Cloud Package',
                'date' => '2023-05-15',
                'status' => 'Completed',
                'amount' => '$99'
            ],
            [
                'id' => 1002,
                'customer' => 'Jane Smith',
                'product' => 'Advanced Analytics Suite',
                'date' => '2023-05-16',
                'status' => 'Processing',
                'amount' => '$149'
            ],
            [
                'id' => 1003,
                'customer' => 'Mike Johnson',
                'product' => 'Enterprise Security Bundle',
                'date' => '2023-05-17',
                'status' => 'Shipped',
                'amount' => '$199'
            ],
            [
                'id' => 1004,
                'customer' => 'Sarah Williams',
                'product' => 'Basic Cloud Package',
                'date' => '2023-05-18',
                'status' => 'Completed',
                'amount' => '$49'
            ],
            [
                'id' => 1005,
                'customer' => 'David Brown',
                'product' => 'Standard Analytics Package',
                'date' => '2023-05-19',
                'status' => 'Pending',
                'amount' => '$79'
            ]
        ];

        return view('admin.orders', compact('orders'));
    }

    public function customers()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $customers = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '(555) 123-4567',
                'status' => 'Active',
                'orders' => 12,
                'total_spent' => '$1,245'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '(555) 234-5678',
                'status' => 'Active',
                'orders' => 8,
                'total_spent' => '$987'
            ],
            [
                'id' => 3,
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '(555) 345-6789',
                'status' => 'Active',
                'orders' => 5,
                'total_spent' => '$678'
            ],
            [
                'id' => 4,
                'name' => 'Sarah Williams',
                'email' => 'sarah.williams@example.com',
                'phone' => '(555) 456-7890',
                'status' => 'Active',
                'orders' => 3,
                'total_spent' => '$456'
            ],
            [
                'id' => 5,
                'name' => 'David Brown',
                'email' => 'david.brown@example.com',
                'phone' => '(555) 567-8901',
                'status' => 'Active',
                'orders' => 2,
                'total_spent' => '$345'
            ]
        ];

        return view('admin.customers', compact('customers'));
    }

    public function settings()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $settings = [
            'site_name' => 'Tech Solutions Inc.',
            'site_email' => 'info@techsolutions.com',
            'site_phone' => '(555) 123-4567',
            'address' => '123 Business Ave, Suite 100, New York, NY 10001',
            'currency' => 'USD',
            'timezone' => 'America/New_York',
            'maintenance_mode' => false,
            'notifications' => [
                'email' => true,
                'sms' => false,
                'push' => true
            ]
        ];

        return view('admin.settings', compact('settings'));
    }
}