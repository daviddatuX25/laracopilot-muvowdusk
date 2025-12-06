<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Inventory System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900" x-data>
    <div class="min-h-screen flex flex-col">
        <!-- Admin Sidebar Drawer -->
        <aside id="admin-sidebar" class="fixed top-0 left-0 z-40 w-64 sm:w-20 lg:w-56 h-screen transition-all duration-300 ease-in-out -translate-x-full sm:translate-x-0" aria-label="Admin Sidebar">
            <div class="h-full w-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
                <!-- Logo Section -->
                <div class="mb-6 px-2 py-1.5 sm:hidden lg:block">
                    <span class="text-xl font-bold text-red-700 dark:text-red-500">🔐 Admin</span>
                </div>

                <!-- Initials Circle (shown on sm) -->
                <div class="mb-6 px-2 py-1.5 w-full xs:hidden lg:hidden">
                    <div class="w-10 h-10 bg-red-700 text-white font-bold rounded-full flex items-center justify-center">
                        AD
                    </div>
                </div>

                <ul class="space-y-2 font-medium sm:flex sm:flex-col sm:items-center lg:items-start">
                    <!-- User Management -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('admin.users') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-red-700 dark:hover:text-red-500 group lg:w-full {{ request()->routeIs('admin.users') ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-500' : '' }}" title="User Management">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-red-700 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="ms-3 sm:hidden lg:inline whitespace-nowrap">Users</span>
                        </a>
                    </li>

                    <!-- Inventories -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('admin.inventories') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-red-700 dark:hover:text-red-500 group lg:w-full {{ request()->routeIs('admin.inventories') ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-500' : '' }}" title="Inventories">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-red-700 dark:group-hover:text-red-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 7l-8-4-8 4m0 0l8-4 8 4m-8 4v10l-8-4v-10l8 4Z"></path>
                            </svg>
                            <span class="ms-3 sm:hidden lg:inline whitespace-nowrap">Inventories</span>
                        </a>
                    </li>

                    <!-- User-Inventory Links -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('admin.user-inventory-links') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-red-700 dark:hover:text-red-500 group lg:w-full {{ request()->routeIs('admin.user-inventory-links') ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-500' : '' }}" title="User-Inventory Links">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-red-700 dark:group-hover:text-red-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 20H4a1 1 0 0 1-1-1v-3a6 6 0 0 1 6-6h3m7 1a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                            </svg>
                            <span class="ms-3 sm:hidden lg:inline whitespace-nowrap">Links</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Admin Top Navigation Bar -->
        <nav class="fixed top-0 left-0 right-0 z-30 bg-red-700 dark:bg-red-900 border-b border-red-800 dark:border-red-950 shadow-md sm:ml-20 lg:ml-56 transition-all duration-300 ease-in-out">
            <div class="px-4 py-3 flex justify-between items-center gap-2 sm:gap-0">
                <!-- Sidebar Toggle Button (Mobile) -->
                <div class="flex items-center gap-2">
                    <button data-drawer-target="admin-sidebar" data-drawer-toggle="admin-sidebar" aria-controls="admin-sidebar" type="button" class="text-white bg-red-600 dark:bg-red-800 hover:bg-red-500 dark:hover:bg-red-700 box-border border border-transparent focus:ring-4 focus:ring-red-200 dark:focus:ring-red-900 font-medium leading-5 rounded text-sm p-2 focus:outline-none inline-flex sm:hidden shrink-0">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                        </svg>
                    </button>
                </div>

                <!-- Title -->
                <div class="flex items-center flex-1 text-white font-bold text-lg sm:text-base">
                    🔐 Admin Panel
                    @if(session('admin_viewing_inventory'))
                        <span class="text-white text-xs bg-red-800 px-2 py-1 rounded ml-3">Viewing: {{ session('selected_inventory_name') }}</span>
                    @endif
                </div>

                <!-- Right Navigation -->
                <div class="flex items-center space-x-4">
                    @if(session('admin_viewing_inventory'))
                        <a href="{{ route('admin.clear-viewing-mode') }}" class="bg-red-600 hover:bg-red-500 text-white font-bold py-1 px-3 rounded text-sm">
                            ← Back
                        </a>
                    @endif

                    <div class="text-white font-medium text-sm hidden sm:block">
                        {{ auth()->check() ? auth()->user()->userid : 'Admin' }}
                    </div>

                    @auth
                        <a href="{{ route('inventory.lobby') }}" class="bg-red-600 hover:bg-red-500 text-white font-bold py-1 px-3 rounded text-sm">
                            📋 Lobby
                        </a>
                        <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-900 hover:bg-red-950 text-white font-bold py-1 px-3 rounded text-sm">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 sm:ml-20 lg:ml-56 transition-all duration-300 ease-in-out mt-16">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4 mb-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4 mb-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 sm:ml-20 lg:ml-56 transition-all duration-300 ease-in-out">
            <div class="py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Inventory System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <!-- Drawer Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('[data-drawer-toggle]');
            const sidebar = document.getElementById('admin-sidebar');

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
        });
    </script>
</body>
</html>
