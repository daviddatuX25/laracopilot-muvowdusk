<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900" x-data>
    <div class="min-h-screen flex flex-col">
        <!-- Sidebar -->
        <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 sm:w-20 lg:w-55 h-screen transition-all duration-300 ease-in-out -translate-x-full sm:translate-x-0" aria-label="Sidebar">
            <div class="h-full w-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
                <!-- Logo Section -->
                <div class="mb-6 px-2 py-1.5 sm:hidden w-full lg:block">
                    <span class="text-xl font-bold text-indigo-600">Inventory</span>
                    {{-- small brand text --}}
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">
                    {{-- current inventory name --}}
                        @auth
                            @php
                                $currentInventoryName = session('selected_inventory_name', 'Inventory');
                            @endphp
                            {{ $currentInventoryName }}
                        @endauth
                    </span>
                </div>
                {{-- xs:hidden sm:block | shows initials of the inventory name with violet that we use --}}
                <div class="mb-6 px-2 py-1.5 w-full hidden sm:block lg:hidden">
                    @auth
                        @php
                            $currentInventoryName = session('selected_inventory_name', 'Inventory');
                            $initials = collect(explode(' ', $currentInventoryName))->map(fn($word) => strtoupper(substr($word, 0, 1)))->join('');
                        @endphp
                        <div class="w-10 h-10 bg-indigo-600 text-white font-bold rounded-full flex items-center justify-center">
                            {{ $initials }}
                        </div>
                    @endauth
                </div>

                <ul class="space-y-2 font-medium sm:flex sm:flex-col sm:items-center lg:items-start">
                    <!-- Dashboard -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="Dashboard">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-indigo-600 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
                            <span class="ms-3 sm:hidden lg:inline whitespace-nowrap">Dashboard</span>
                        </a>
                    </li>

                    <!-- Products -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('products.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('products.*') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="Products">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Products</span>
                        </a>
                    </li>

                    <!-- Categories -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('categories.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('categories.*') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="Categories">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Categories</span>
                        </a>
                    </li>

                    <!-- Suppliers -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('suppliers.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="Suppliers">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Suppliers</span>
                        </a>
                    </li>

                    <!-- Reports -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('reports.index') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('reports.*') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="Reports">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6A9.5 9.5 0 1 0 20 15.5M13 13h8m-8-6h6m.5-3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Reports</span>
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->is_admin && !session('admin_viewing_inventory'))
                        <!-- Admin Divider -->
                        <li class="w-full border-t border-gray-300 dark:border-gray-600 my-2"></li>

                        <!-- Admin Section Header -->
                        <li class="w-full px-2 py-1.5 text-gray-600 dark:text-gray-400 text-xs font-semibold uppercase sm:hidden lg:block">Admin Panel</li>

                        <!-- User Management -->
                        <li class="w-full sm:w-auto lg:w-full">
                            <a href="{{ route('admin.users') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('admin.users') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="User Management">
                                <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                                <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Users</span>
                            </a>
                        </li>

                        <!-- Inventory Management -->
                        <li class="w-full sm:w-auto lg:w-full">
                            <a href="{{ route('admin.inventories') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('admin.inventories') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="Inventory Management">
                                <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8-4 8 4m-8 4v10l-8-4v-10l8 4Z"/></svg>
                                <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Inventories</span>
                            </a>
                        </li>

                        <!-- User-Inventory Links -->
                        <li class="w-full sm:w-auto lg:w-full">
                            <a href="{{ route('admin.user-inventory-links') }}" class="flex items-center px-2 py-1.5 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 group lg:w-full {{ request()->routeIs('admin.user-inventory-links') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : '' }}" title="User-Inventory Links">
                                <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20H4a1 1 0 0 1-1-1v-3a6 6 0 0 1 6-6h3m7 1a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Links</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </aside>

        <!-- Top Navigation Bar (Notification & Profile) -->
        <nav class="fixed top-0 left-0 right-0 z-30 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sm:ml-20 lg:ml-55 transition-all duration-300 ease-in-out">
            <div class="px-4 py-3 flex justify-between items-center gap-2 sm:gap-0">
                <!-- Sidebar Toggle Button (Mobile) and Back Navigation -->
                <div class="flex items-center gap-2">
                    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium leading-5 rounded text-sm p-2 focus:outline-none inline-flex sm:hidden shrink-0 transition">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                        </svg>
                    </button>

                    <!-- Back Button (shows on inner pages) -->
                    @php
                        $isInnerPage = !in_array(request()->route()?->getName(), [
                            'dashboard',
                            'products.index',
                            'categories.index',
                            'suppliers.index',
                            'stock-adjustment',
                            'reports.index'
                        ]);
                    @endphp
                    @if($isInnerPage)
                        <button onclick="history.back()" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium leading-5 rounded text-sm p-2 focus:outline-none inline-flex shrink-0 sm:inline-flex transition" title="Go Back">
                            <span class="sr-only">Go Back</span>
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l7-7m-7 7l7 7"/>
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Page Title (shown on mobile) -->
                <div class="flex items-center flex-1">
                    @if (isset($header))
                        <div class="text-gray-900 dark:text-white">{{ $header }}</div>
                    @else
                        <h1 class="text-lg font-semibold text-gray-900 dark:text-white sm:hidden">Inventory</h1>
                    @endif
                </div>

                <!-- Notification Center & Greeting -->
                <div class="flex items-center space-x-4 mx-2 md:mx-10 ">
                    <!-- Greeting -->
                    <div class="text-gray-700 dark:text-gray-300 font-medium text-sm hidden sm:block">
                        {{ auth()->check() ? 'Welcome, ' . auth()->user()->userid : 'Welcome to Inventory System' }}
                    </div>

                    <!-- Back to Lobby Button -->
                    @auth
                        <a href="{{ route('inventory.lobby') }}" class="border-2 border-violet-600 dark:border-violet-400 text-violet-600 dark:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 font-bold py-1 px-3 rounded text-sm transition">
                            Back to Lobby
                        </a>
                    @endauth
                    <!-- Notification Center Component -->
                    @livewire('notification-center')
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
        @endif

        <!-- Main Content -->
        <main class="flex-1 sm:ml-20 lg:ml-55 transition-all duration-300 ease-in-out mt-16 bg-gray-50 dark:bg-gray-900">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 sm:ml-20 lg:ml-64 transition-all duration-300 ease-in-out">
            <div class="py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
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
