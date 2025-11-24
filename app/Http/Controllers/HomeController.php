<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $features = [
            [
                'title' => 'Advanced Analytics',
                'description' => 'Get deep insights into your business performance with real-time analytics and custom reports.',
                'icon' => 'chart-line'
            ],
            [
                'title' => 'Enterprise Security',
                'description' => 'Comprehensive security solution with encryption and compliance monitoring.',
                'icon' => 'shield-check'
            ],
            [
                'title' => 'Scalable Infrastructure',
                'description' => 'Built to grow with your business, our platform scales effortlessly.',
                'icon' => 'server'
            ],
            [
                'title' => '24/7 Support',
                'description' => 'Our dedicated support team is available around the clock to assist you.',
                'icon' => 'headset'
            ]
        ];

        $services = [
            [
                'title' => 'Cloud Solutions',
                'description' => 'Secure, scalable cloud infrastructure tailored to your business needs.',
                'icon' => 'cloud'
            ],
            [
                'title' => 'Data Analytics',
                'description' => 'Transform your data into actionable insights with our advanced analytics tools.',
                'icon' => 'database'
            ],
            [
                'title' => 'Cybersecurity',
                'description' => 'Protect your business with our comprehensive cybersecurity solutions.',
                'icon' => 'lock-closed'
            ]
        ];

        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'position' => 'CEO, TechCorp',
                'quote' => 'This platform has revolutionized our business operations. The analytics tools are unmatched in the industry.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20woman%20headshot%20modern%20corporate%20style/400/400'
            ],
            [
                'name' => 'Michael Chen',
                'position' => 'CTO, DataSolutions',
                'quote' => 'The security features give us complete peace of mind. Our data is protected at all times.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20man%20headshot%20modern%20corporate%20style/400/400'
            ]
        ];

        return view('welcome', compact('features', 'services', 'testimonials'));
    }

    public function about()
    {
        $team = [
            [
                'name' => 'Emily Rodriguez',
                'position' => 'CEO',
                'bio' => 'Emily leads our company with over 20 years of experience in the tech industry.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20woman%20headshot%20modern%20corporate%20style/400/400'
            ],
            [
                'name' => 'David Kim',
                'position' => 'CTO',
                'bio' => 'David oversees our technical strategy and ensures our platform remains cutting-edge.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20man%20headshot%20modern%20corporate%20style/400/400'
            ],
            [
                'name' => 'Jessica Wong',
                'position' => 'CFO',
                'bio' => 'Jessica manages our financial operations with a focus on growth and sustainability.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20woman%20headshot%20modern%20corporate%20style/400/400'
            ]
        ];

        return view('about', compact('team'));
    }

    public function services()
    {
        $services = [
            [
                'title' => 'Cloud Solutions',
                'description' => 'Secure, scalable cloud infrastructure tailored to your business needs.',
                'icon' => 'cloud',
                'features' => ['24/7 uptime', 'Automatic backups', 'Global data centers'],
                'pricing' => [
                    'Basic' => '$99/month',
                    'Pro' => '$299/month',
                    'Enterprise' => 'Custom pricing'
                ]
            ],
            [
                'title' => 'Data Analytics',
                'description' => 'Transform your data into actionable insights with our advanced analytics tools.',
                'icon' => 'database',
                'features' => ['Real-time processing', 'Custom dashboards', 'Predictive modeling'],
                'pricing' => [
                    'Basic' => '$149/month',
                    'Pro' => '$399/month',
                    'Enterprise' => 'Custom pricing'
                ]
            ],
            [
                'title' => 'Cybersecurity',
                'description' => 'Protect your business with our comprehensive cybersecurity solutions.',
                'icon' => 'lock-closed',
                'features' => ['256-bit encryption', 'Threat detection', 'Compliance monitoring'],
                'pricing' => [
                    'Basic' => '$199/month',
                    'Pro' => '$499/month',
                    'Enterprise' => 'Custom pricing'
                ]
            ]
        ];

        return view('services', compact('services'));
    }

    public function contact()
    {
        return view('contact');
    }
}