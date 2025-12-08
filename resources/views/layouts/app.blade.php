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
            <div class="h-full w-full px-3 py-4 overflow-y-auto bg-gradient-to-b from-violet-100 via-purple-100 to-indigo-100 dark:bg-gradient-to-b dark:from-violet-950 dark:via-purple-950 dark:to-indigo-950 border-r border-violet-300 dark:border-violet-800 flex flex-col">
                <!-- Logo Section -->
                <div class="mb-6 px-2 py-1.5 sm:hidden w-full lg:block">
                    <span class="text-xl font-bold text-violet-700 dark:text-violet-300">Inventory</span>
                    {{-- small brand text --}}
                    <span class="text-sm font-medium text-violet-600 dark:text-violet-400 block">
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
                        <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('dashboard') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Dashboard">
                            <svg class="w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
                            <span class="ms-3 sm:hidden lg:inline whitespace-nowrap">Dashboard</span>
                        </a>
                    </li>

                    <!-- Products -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('products.index') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('products.*') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Products">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Products</span>
                        </a>
                    </li>

                    <!-- Categories -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('categories.index') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('categories.*') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Categories">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Categories</span>
                        </a>
                    </li>

                    <!-- Suppliers -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('suppliers.index') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('suppliers.*') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Suppliers">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Suppliers</span>
                        </a>
                    </li>

                    <!-- Reports -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('reports.index') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('reports.*') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Reports">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6A9.5 9.5 0 1 0 20 15.5M13 13h8m-8-6h6m.5-3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Reports</span>
                        </a>
                    </li>

                    <!-- Stock In-Out -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('stock-movements.adjust') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('stock-movements.*') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Stock In-Out">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" style="enable-background:new 0 0 128 128" xml:space="preserve"><path fill="currentColor" d="M33.8 53.3 30 49.5-.1 79.7 30 109.9l3.8-3.8L10 82.3h63.2v-5.2H10l23.8-23.8zm94.1-5.1L97.8 18.1 94 21.9l23.8 23.8h-63v5.2h63L94.1 74.8l3.8 3.8L128 48.5v-.3h-.1z"/></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Stock In-Out</span>
                        </a>
                    </li>

                    <!-- Restock Planner -->
                    <li class="w-full sm:w-auto lg:w-full">
                        <a href="{{ route('restock.plans') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('restock.*') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Restock Planner">
                            <svg  class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" version="1.1" id="shopping_x5F_carts_1_" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 128 128" xml:space="preserve"><style>.st0{display:none}.st1{display:inline}.st2{fill:currentColor}</style><g id="_x34__1_"><path class="st2" d="M45.3 81.2h78V43.7L35.9 25.4l-3.1-12.9-12.6-4.2c0-.2.1-.3.1-.5 0-4.3-3.5-7.8-7.8-7.8S4.7 3.5 4.7 7.8s3.5 7.8 7.8 7.8c1.8 0 3.4-.6 4.7-1.6l9.4 4.7L39 78l-12.5 9.4V103l5.7 7.1c-1.6 1.9-2.5 4.3-2.5 7 0 6 4.9 10.9 10.9 10.9s10.9-4.9 10.9-10.9-4.9-10.9-10.9-10.9c-.9 0-1.8.1-2.6.3l-2.1-3.4h65.6l3.6 6c-2.2 2-3.6 4.9-3.6 8.1 0 6 4.9 10.9 10.9 10.9s10.9-4.9 10.9-10.9-4.9-10.9-10.9-10.9h-.3l-1.3-3.1h12.5V97H32.8v-6.2l12.5-9.6zm0-6.3-4.6-21.4.6 3L59.8 58l3.8 17H45.3zm21.8 0-3.7-16.7 18.1 1.4 1.4 15.3H67.1zm18.8 0-1.4-15 17 1.3v13.7H85.9zm31.2-15.6v15.6h-12.5V61.5l12.5 1v-3.2l-12.5-1V44.4l12.5 2.4v12.5zM35.9 31.2l65.6 12.6V58l-17.3-1.4-1.5-16.4-3.1-.6 1.6 16.8-18.5-1.5-4.3-19.3-3.7-.7 4.4 19.7-18.5-1.5-4.7-21.9zm76.5 81.2c2.6 0 4.7 2.1 4.7 4.7s-2.1 4.7-4.7 4.7-4.7-2.1-4.7-4.7 2.1-4.7 4.7-4.7zm-71.8 0c2.6 0 4.7 2.1 4.7 4.7s-2.1 4.7-4.7 4.7-4.7-2.1-4.7-4.7 2.1-4.7 4.7-4.7z" id="icon_11_"/></g></svg>
                            <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Restock Planner</span>
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->is_admin && !session('admin_viewing_inventory'))
                        <!-- Admin Divider -->
                        <li class="w-full border-t border-violet-300 dark:border-violet-700 my-2"></li>

                        <!-- Admin Section Header -->
                        <li class="w-full px-2 py-1.5 text-violet-700 dark:text-violet-300 text-xs font-semibold uppercase sm:hidden lg:block">Admin Panel</li>

                        <!-- User Management -->
                        <li class="w-full sm:w-auto lg:w-full">
                            <a href="{{ route('admin.users') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('admin.users') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="User Management">
                                <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                                <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Users</span>
                            </a>
                        </li>

                        <!-- Inventory Management -->
                        <li class="w-full sm:w-auto lg:w-full">
                            <a href="{{ route('admin.inventories') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('admin.inventories') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="Inventory Management">
                                <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8-4 8 4m-8 4v10l-8-4v-10l8 4Z"/></svg>
                                <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Inventories</span>
                            </a>
                        </li>

                        <!-- User-Inventory Links -->
                        <li class="w-full sm:w-auto lg:w-full">
                            <a href="{{ route('admin.user-inventory-links') }}" class="flex items-center px-2 py-1.5 text-gray-700 dark:text-gray-200 rounded hover:bg-violet-200/40 dark:hover:bg-violet-900/40 hover:text-violet-700 dark:hover:text-violet-300 group lg:w-full transition {{ request()->routeIs('admin.user-inventory-links') ? 'bg-violet-200/50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold' : '' }}" title="User-Inventory Links">
                                <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-violet-700 dark:group-hover:text-violet-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20H4a1 1 0 0 1-1-1v-3a6 6 0 0 1 6-6h3m7 1a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                <span class="ms-3 whitespace-nowrap sm:hidden lg:inline">Links</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </aside>

        <!-- Top Navigation Bar (Notification & Profile) -->
        <nav class="fixed top-0 left-0 right-0 z-30 bg-gradient-to-r from-violet-700 via-purple-700 to-indigo-700 dark:bg-gradient-to-r dark:from-violet-900 dark:via-purple-900 dark:to-indigo-900 border-b border-violet-600 dark:border-violet-800 sm:ml-20 lg:ml-55 transition-all duration-300 ease-in-out">
            <div class="px-4 py-3 flex justify-between items-center gap-2 sm:gap-0">
                <!-- Sidebar Toggle Button (Mobile) and Back Navigation -->
                <div class="flex items-center gap-2">
                    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="text-white dark:text-violet-100 hover:text-violet-100 dark:hover:text-white font-medium leading-5 rounded text-sm p-2 focus:outline-none inline-flex sm:hidden shrink-0 transition">
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
                            'reports.index',
                            'restock.plans'
                        ]);
                    @endphp
                    @if($isInnerPage)
                        <button onclick="history.back()" class="text-white dark:text-violet-100 hover:text-violet-100 dark:hover:text-white font-medium leading-5 rounded text-sm p-2 focus:outline-none inline-flex shrink-0 sm:inline-flex transition" title="Go Back">
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
                        <div class="text-lg sm:text-xl text-white dark:text-violet-100">{{ $header }}</div>
                    @else
                        <h1 class="text-lg sm:text-xl font-semibold text-white dark:text-violet-100 sm:hidden">Inventory</h1>
                    @endif
                </div>

                <!-- Notification Center & Greeting -->
                <div class="flex items-center space-x-2 md:space-x-4 mx-1 md:mx-10 ">
                    <!-- Greeting -->
                    <div class="text-white dark:text-violet-100 font-medium text-xs sm:text-sm hidden sm:block mx-5">
                        {{ auth()->check() ? 'Welcome, ' . auth()->user()->userid : 'Welcome to Inventory System' }}
                    </div>

                    <!-- Back to Lobby Button (Exit Icon) -->
                    @auth
                        <a href="{{ route('inventory.lobby') }}" class="text-white dark:text-violet-100 hover:bg-white/20 dark:hover:bg-violet-500/30 font-bold py-1 px-2 rounded text-sm transition shrink-0" title="Exit to Lobby">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12L6 12M6 12L8 14M6 12L8 10"/>
                                <path stroke-linecap="round" stroke-width="1.5" d="M12 21.9827C10.4465 21.9359 9.51995 21.7626 8.87865 21.1213C8.11027 20.3529 8.01382 19.175 8.00171 17M16 21.9983C18.175 21.9862 19.3529 21.8897 20.1213 21.1213C21 20.2426 21 18.8284 21 16V14V10V8C21 5.17157 21 3.75736 20.1213 2.87868C19.2426 2 17.8284 2 15 2H14C11.1715 2 9.75733 2 8.87865 2.87868C8.11027 3.64706 8.01382 4.82497 8.00171 7"/>
                                <path stroke-linecap="round" stroke-width="1.5" d="M3 9.5V14.5C3 16.857 3 18.0355 3.73223 18.7678C4.46447 19.5 5.64298 19.5 8 19.5M3.73223 5.23223C4.46447 4.5 5.64298 4.5 8 4.5"/>
                            </svg>
                        </a>
                    @endauth
                    <!-- Notification Center Component -->
                    <div class="shrink-0 mt-1">
                        @livewire('notification-center')
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
        @endif

        <!-- Main Content -->
        <main class="flex-1 sm:ml-20 lg:ml-55 transition-all duration-300 ease-in-out mt-16 bg-gradient-to-br from-violet-50 via-purple-50 to-indigo-50 dark:bg-gradient-to-br dark:from-gray-800 dark:via-violet-900/20 dark:to-gray-800">
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

                @yield('content', $slot ?? '')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-violet-100 via-purple-100 to-indigo-100 dark:bg-gradient-to-r dark:from-violet-950/40 dark:via-purple-950/40 dark:to-indigo-950/40 border-t border-violet-200 dark:border-violet-800 sm:ml-20 lg:ml-64 transition-all duration-300 ease-in-out">
            <div class="py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-violet-700 dark:text-violet-300 text-sm">
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
