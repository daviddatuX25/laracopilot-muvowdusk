<x-app-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">About Us</h1>
            <p class="mt-2 text-lg text-gray-600">Meet the team behind the Inventory Management System</p>
        </div>

    <!-- Mission Section -->
    <div class="bg-white rounded-lg shadow-md p-8 border-l-4 border-indigo-600">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h2>
        <p class="text-gray-700 leading-relaxed">
            We are committed to providing a simple, efficient, and reliable inventory management system that helps businesses
            track their products, manage stock levels, and maintain accurate records. Our goal is to make inventory management
            accessible to everyone, from small retailers to warehouse operators.
        </p>
    </div>

    <!-- Features Section -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">What We Offer</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10l8-4" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Product Management</h3>
                    <p class="mt-2 text-gray-600">Easily manage products with SKUs, barcodes, categories, and detailed information.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Stock Tracking</h3>
                    <p class="mt-2 text-gray-600">Track stock movements in real-time with complete audit trails and history.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Supplier Management</h3>
                    <p class="mt-2 text-gray-600">Maintain detailed supplier information and track product sources.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Barcode Scanning</h3>
                    <p class="mt-2 text-gray-600">Quick product lookup using camera-based barcode and QR code scanning.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Smart Alerts</h3>
                    <p class="mt-2 text-gray-600">Automatic notifications when stock levels fall below reorder thresholds.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Detailed Reports</h3>
                    <p class="mt-2 text-gray-600">Generate comprehensive reports and export to PDF for analysis and sharing.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Team Member 1 -->
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                    DD
                </div>
                <h3 class="text-xl font-semibold text-gray-900">David Datu Sarmiento</h3>
                <p class="text-indigo-600 font-medium">Lead Developer</p>
                <p class="text-gray-600 mt-2 text-sm">Full-stack developer with expertise in Laravel and modern web technologies.</p>
            </div>

            <!-- Team Member 2 -->
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                    CL
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Christine Lopez</h3>
                <p class="text-indigo-600 font-medium">Designer</p>
                <p class="text-gray-600 mt-2 text-sm">Creative designer focused on user experience and intuitive interfaces.</p>
            </div>

            <!-- Team Member 3 -->
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                    PH
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Peter John Haboc</h3>
                <p class="text-indigo-600 font-medium">Database Administrator</p>
                <p class="text-gray-600 mt-2 text-sm">Specializes in database architecture and optimization.</p>
            </div>

            <!-- Team Member 4 -->
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                    AA
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Albrix Astro</h3>
                <p class="text-indigo-600 font-medium">System Administrator</p>
                <p class="text-gray-600 mt-2 text-sm">Manages system deployment, maintenance, and infrastructure.</p>
            </div>
        </div>
    </div>

    <!-- Technology Stack Section -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Technology Stack</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Backend</h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>Laravel 12 Framework</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>PHP 8.4</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>MySQL / SQLite Database</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>Eloquent ORM</span>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Frontend</h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>Livewire 3 Components</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>Tailwind CSS</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>Alpine.js</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-indigo-600">✓</span>
                        <span>Blade Templating</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-indigo-50 rounded-lg p-8 border border-indigo-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Get in Touch</h2>
        <p class="text-gray-700 mb-4">
            Have questions about our inventory management system? We'd love to hear from you!
        </p>
        <div class="mt-6 flex gap-4">
            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-white text-indigo-600 font-semibold rounded-lg border border-indigo-600 hover:bg-indigo-50 transition">
                Back to System
            </a>
        </div>
    </div>
</x-app-layout>
