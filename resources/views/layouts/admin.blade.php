<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Inventory System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Admin Top Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-30 bg-red-700 border-b border-red-800 shadow-md">
            <div class="px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <h1 class="text-white font-bold text-lg">🔐 Admin Panel</h1>
                    @if(session('admin_viewing_inventory'))
                        <span class="text-white text-sm bg-red-800 px-2 py-1 rounded">Viewing: {{ session('selected_inventory_name') }}</span>
                    @endif
                </div>

                <div class="flex items-center space-x-4">
                    @if(session('admin_viewing_inventory'))
                        <a href="{{ route('admin.clear-viewing-mode') }}" class="bg-red-600 hover:bg-red-500 text-white font-bold py-1 px-3 rounded text-sm">
                            ← Back to Admin
                        </a>
                    @endif
                    <div class="text-white font-medium text-sm hidden sm:block">
                        {{ auth()->check() ? 'Logged in as: ' . auth()->user()->userid : 'Admin' }}
                    </div>
                    @auth
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

        <!-- Admin Sidebar & Content -->
        <div class="flex pt-16 flex-1">
            <!-- Sidebar -->
            <aside class="w-56 bg-white border-r border-gray-200 shadow-sm fixed left-0 top-16 bottom-0 overflow-y-auto">
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Admin Menu</h2>
                    <nav class="space-y-2">
                        <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            User Management
                        </a>

                        <a href="{{ route('admin.inventories') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.inventories') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 7l-8-4-8 4m0 0l8-4 8 4m-8 4v10l-8-4v-10l8 4Z"></path>
                            </svg>
                            Inventories
                        </a>

                        <a href="{{ route('admin.user-inventory-links') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.user-inventory-links') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 20H4a1 1 0 0 1-1-1v-3a6 6 0 0 1 6-6h3m7 1a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                            </svg>
                            User-Inventory Links
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 ml-56 p-6">
                @if(session('success'))
                    <div class="rounded-md bg-green-50 p-4 mb-4">
                        <div class="flex">
                            <div class="shrink-0">
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
                            <div class="shrink-0">
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
            </main>
        </div>
    </div>
</body>
</html>
