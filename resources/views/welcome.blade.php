@extends('layouts.app')

@section('title', 'Tech Solutions Inc. - Innovative Business Solutions')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-slate-900 to-slate-800 text-white py-20 md:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">Transform Your Business with Advanced Technology</h1>
                    <p class="text-xl text-slate-200">We provide cutting-edge solutions to help your business grow and succeed in the digital age.</p>
                    <div class="flex space-x-4">
                        <a href="/services" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-slate-900 bg-white hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200">
                            Explore Services
                        </a>
                        <a href="/contact" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Get in Touch
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="https://image.pollinations.ai/prompt/modern%20business%20technology%20hero%20image%20professional%20corporate%20style%20gradient%20background/800/600" alt="Business Technology" class="rounded-xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Our Key Features</h2>
                <p class="mt-4 text-xl text-gray-500">Discover the powerful tools we offer to enhance your business operations</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($features as $feature)
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-slate-200/50">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                @if($feature['icon'] == 'chart-line')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                @elseif($feature['icon'] == 'shield-check')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                @elseif($feature['icon'] == 'server')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2m-4-4h4m-2 4h2m-6 4h.01M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2"/>
                                @elseif($feature['icon'] == 'headset')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                @endif
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-500">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <img src="https://image.pollinations.ai/prompt/professional%20business%20team%20collaboration%20modern%20corporate%20style%20gradient%20background/800/600" alt="Our Team" class="rounded-xl shadow-2xl">
                </div>
                <div class="order-1 md:order-2 space-y-6">
                    <h2 class="text-3xl font-bold text-gray-900">About TechSolutions</h2>
                    <p class="text-xl text-gray-500">We are a team of dedicated professionals committed to delivering innovative solutions for your business needs.</p>
                    <p class="text-gray-600">Founded in 2010, TechSolutions has been at the forefront of technological innovation, helping businesses of all sizes leverage cutting-edge solutions to achieve their goals. Our team of experts combines deep industry knowledge with a passion for technology to create tailored solutions that drive success.</p>
                    <div class="flex space-x-4">
                        <a href="/about" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Our Services</h2>
                <p class="mt-4 text-xl text-gray-500">Comprehensive solutions tailored to your business needs</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                    <div class="bg-slate-50 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-slate-200/50">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                @if($service['icon'] == 'cloud')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                @elseif($service['icon'] == 'database')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                @elseif($service['icon'] == 'lock-closed')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                @endif
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service['title'] }}</h3>
                        <p class="text-gray-500 mb-4">{{ $service['description'] }}</p>
                        <a href="/services#{{ strtolower(str_replace(' ', '-', $service['title'])) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                            Learn More
                            <svg class="h-5 w-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gradient-to-r from-slate-900 to-slate-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">What Our Clients Say</h2>
                <p class="mt-4 text-xl text-slate-200">Hear from businesses that have transformed with our solutions</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-8 shadow-lg border border-white/20">
                        <div class="flex items-center mb-6">
                            <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}" class="h-16 w-16 rounded-full object-cover border-2 border-blue-500">
                            <div class="ml-4">
                                <h4 class="text-xl font-semibold">{{ $testimonial['name'] }}</h4>
                                <p class="text-slate-300">{{ $testimonial['position'] }}</p>
                            </div>
                        </div>
                        <p class="text-lg italic text-slate-100">"{{ $testimonial['quote'] }}"</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Get in Touch</h2>
                <p class="mt-4 text-xl text-gray-500">We'd love to hear from you. Let's start a conversation</p>
            </div>
            <div class="max-w-2xl mx-auto">
                <form action="/contact" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="message" id="message" rows="5" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Add any jQuery functionality here
            console.log('Welcome page loaded');
        });
    </script>
@endsection