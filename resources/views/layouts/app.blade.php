<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" x-data>
    <div class="min-h-screen flex flex-col">
        <!-- Sidebar -->
        <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200">
                <!-- Logo Section -->
                <div class="mb-6 px-2 py-1.5">
                    <span class="text-xl font-bold text-indigo-600">Inventory</span>
                </div>

                <ul class="space-y-2 font-medium">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-1.5 text-gray-900 rounded hover:bg-gray-100 hover:text-indigo-600 group {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-indigo-600' : '' }}">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>

                    <!-- Products -->
                    <li>
                        <a href="{{ route('products.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 rounded hover:bg-gray-100 hover:text-indigo-600 group {{ request()->routeIs('products.*') ? 'bg-gray-100 text-indigo-600' : '' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                        </a>
                    </li>

                    <!-- Categories -->
                    <li>
                        <a href="{{ route('categories.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 rounded hover:bg-gray-100 hover:text-indigo-600 group {{ request()->routeIs('categories.*') ? 'bg-gray-100 text-indigo-600' : '' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Categories</span>
                        </a>
                    </li>

                    <!-- Suppliers -->
                    <li>
                        <a href="{{ route('suppliers.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 rounded hover:bg-gray-100 hover:text-indigo-600 group {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 text-indigo-600' : '' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Suppliers</span>
                        </a>
                    </li>

                    <!-- Stock Movements -->
                    <li>
                        <a href="{{ route('stock-movements.adjust') }}" class="flex items-center px-2 py-1.5 text-gray-900 rounded hover:bg-gray-100 hover:text-indigo-600 group {{ request()->routeIs('stock-movements.*') ? 'bg-gray-100 text-indigo-600' : '' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Stock Movements</span>
                        </a>
                    </li>

                    <!-- Reports -->
                    <li>
                        <a href="{{ route('reports.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 rounded hover:bg-gray-100 hover:text-indigo-600 group {{ request()->routeIs('reports.*') ? 'bg-gray-100 text-indigo-600' : '' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6A9.5 9.5 0 1 0 20 15.5M13 13h8m-8-6h6m.5-3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Reports</span>
                        </a>
                    </li>

                    <!-- About -->
                    <li>
                        <a href="{{ route('about') }}" class="flex items-center px-2 py-1.5 text-gray-900 rounded hover:bg-gray-100 hover:text-indigo-600 group {{ request()->routeIs('about') ? 'bg-gray-100 text-indigo-600' : '' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">About</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Top Navigation Bar (Notification & Profile) -->
        <nav class="bg-white border-b border-gray-200 sm:ml-64">
            <div class="px-4 py-3 flex justify-between items-center gap-2 sm:gap-0">
                <!-- Sidebar Toggle Button (Mobile) -->
                <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="text-gray-700 bg-white box-border border border-transparent hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium leading-5 rounded text-sm p-2 focus:outline-none inline-flex sm:hidden shrink-0">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                    </svg>
                </button>

                <!-- Page Title (shown on mobile) -->
                <div class="flex items-center flex-1">
                    <h1 class="text-lg font-semibold text-gray-900 sm:hidden">Inventory</h1>
                </div>

                <!-- Notification Center & Greeting -->
                <div class="flex items-center space-x-4">
                    <!-- Notification Center Component -->
                    @livewire('notification-center')

                    <!-- Greeting -->
                    <div class="text-gray-700 font-medium text-sm hidden sm:block">
                        Welcome to Inventory System
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white border-b border-gray-200 sm:ml-64">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="flex-1 sm:ml-64">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="rounded-md bg-green-50 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="rounded-md bg-red-50 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 sm:ml-64">
            <div class="py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Inventory System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    @stack('scripts')

    <!-- Toast Component -->
    @livewire('toast')

    <!-- Drawer/Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('[data-drawer-toggle]');
            const sidebar = document.getElementById('sidebar-multi-level-sidebar');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            });

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnButton = Array.from(toggleButtons).some(btn => btn.contains(event.target));

                if (!isClickInsideSidebar && !isClickOnButton && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Handle collapse toggles
            const collapseButtons = document.querySelectorAll('[data-collapse-toggle]');
            collapseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-collapse-toggle');
                    const target = document.getElementById(targetId);
                    if (target) {
                        target.classList.toggle('hidden');
                        const icon = this.querySelector('svg:last-child');
                        if (icon) {
                            icon.classList.toggle('rotate-180');
                        }
                    }
                });
            });
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>
