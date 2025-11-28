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
                'description' => 'Get deep insights into your business performance with real-time analytics, custom reports, and predictive modeling.',
                'icon' => 'chart-line',
                'color' => 'blue',
                'benefits' => ['Real-time monitoring', 'Custom reports', 'Predictive analytics'],
                'metrics' => ['99.9% uptime', '10x faster insights', '50+ integrations']
            ],
            [
                'title' => 'Enterprise Security',
                'description' => 'Comprehensive security solution with encryption, compliance monitoring, and threat detection.',
                'icon' => 'shield-check',
                'color' => 'green',
                'benefits' => ['256-bit encryption', 'Compliance automation', 'Threat detection'],
                'metrics' => ['SOC2 compliant', '24/7 monitoring', '99.99% security rating']
            ],
            [
                'title' => 'Automated Workflows',
                'description' => 'Streamline your operations with automated workflows that integrate seamlessly with your existing systems.',
                'icon' => 'cog',
                'color' => 'purple',
                'benefits' => ['Process automation', 'System integration', 'Workflow optimization'],
                'metrics' => ['50% time savings', '98% accuracy', '100+ integrations']
            ],
            [
                'title' => 'Customer Insights',
                'description' => 'Understand your customers better with advanced segmentation, behavior tracking, and personalized recommendations.',
                'icon' => 'users',
                'color' => 'orange',
                'benefits' => ['Customer segmentation', 'Behavior analysis', 'Personalized recommendations'],
                'metrics' => ['30% conversion boost', '20% retention increase', 'Real-time insights']
            ]
        ];

        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'position' => 'CEO, TechCorp',
                'quote' => 'This platform has transformed our business operations. The analytics tools provide invaluable insights that have directly contributed to our growth.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20woman%20headshot%20corporate%20clean%20minimalist/400/400'
            ],
            [
                'name' => 'Michael Chen',
                'position' => 'CTO, Innovate Solutions',
                'quote' => 'The security features give us peace of mind. We\'ve seen a significant reduction in security incidents since implementing this solution.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20man%20headshot%20corporate%20clean%20minimalist/400/400'
            ],
            [
                'name' => 'Emily Rodriguez',
                'position' => 'Marketing Director, Global Brands',
                'quote' => 'Our customer retention has improved dramatically thanks to the personalized recommendations. It\'s clear this platform understands our customers better than we do.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20woman%20headshot%20corporate%20clean%20minimalist/400/400'
            ]
        ];

        return view('welcome', compact('features', 'testimonials'));
    }

    public function about()
    {
        $team = [
            [
                'name' => 'John Smith',
                'position' => 'CEO & Founder',
                'bio' => 'John has over 20 years of experience in the tech industry, specializing in business solutions and innovation.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20man%20headshot%20corporate%20clean%20minimalist/400/400'
            ],
            [
                'name' => 'Sarah Johnson',
                'position' => 'Chief Technology Officer',
                'bio' => 'Sarah leads our technical team with a focus on cutting-edge solutions and operational efficiency.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20woman%20headshot%20corporate%20clean%20minimalist/400/400'
            ],
            [
                'name' => 'Michael Chen',
                'position' => 'Chief Product Officer',
                'bio' => 'Michael oversees our product development, ensuring we deliver innovative solutions that meet market needs.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20man%20headshot%20corporate%20clean%20minimalist/400/400'
            ],
            [
                'name' => 'Emily Rodriguez',
                'position' => 'Chief Marketing Officer',
                'bio' => 'Emily leads our marketing strategy, focusing on brand growth and customer engagement.',
                'image' => 'https://image.pollinations.ai/prompt/professional%20business%20woman%20headshot%20corporate%20clean%20minimalist/400/400'
            ]
        ];

        $history = [
            [
                'year' => '2010',
                'event' => 'Company founded with a mission to revolutionize business operations through technology.'
            ],
            [
                'year' => '2012',
                'event' => 'Launched our first analytics platform, gaining immediate traction in the market.'
            ],
            [
                'year' => '2015',
                'event' => 'Expanded our security solutions, becoming a leader in enterprise security.'
            ],
            [
                'year' => '2018',
                'event' => 'Introduced automated workflows, significantly improving operational efficiency for our clients.'
            ],
            [
                'year' => '2020',
                'event' => 'Developed advanced customer insights tools, helping businesses understand their customers better than ever.'
            ],
            [
                'year' => '2023',
                'event' => 'Achieved 1 million active users, solidifying our position as an industry leader.'
            ]
        ];

        return view('about', compact('team', 'history'));
    }

    public function services()
    {
        $services = [
            [
                'title' => 'Analytics Solutions',
                'description' => 'Comprehensive analytics tools to help you make data-driven decisions and optimize your business performance.',
                'icon' => 'chart-line',
                'color' => 'blue',
                'features' => ['Real-time analytics', 'Custom reports', 'Predictive modeling'],
                'price' => '$99/month',
                'cta' => 'Get Started'
            ],
            [
                'title' => 'Security Services',
                'description' => 'Enterprise-grade security solutions to protect your data and ensure compliance with industry standards.',
                'icon' => 'shield-check',
                'color' => 'green',
                'features' => ['256-bit encryption', 'Compliance monitoring', 'Threat detection'],
                'price' => '$149/month',
                'cta' => 'Learn More'
            ],
            [
                'title' => 'Workflow Automation',
                'description' => 'Streamline your operations with automated workflows that integrate seamlessly with your existing systems.',
                'icon' => 'cog',
                'color' => 'purple',
                'features' => ['Process automation', 'System integration', 'Workflow optimization'],
                'price' => '$129/month',
                'cta' => 'Try Free'
            ],
            [
                'title' => 'Customer Insights',
                'description' => 'Advanced customer segmentation and behavior analysis to help you understand and engage your customers more effectively.',
                'icon' => 'users',
                'color' => 'orange',
                'features' => ['Customer segmentation', 'Behavior analysis', 'Personalized recommendations'],
                'price' => '$79/month',
                'cta' => 'Get Started'
            ]
        ];

        return view('services', compact('services'));
    }

    public function contact()
    {
        return view('contact');
    }
}