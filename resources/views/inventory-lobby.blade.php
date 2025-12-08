<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Lobby - Inventory System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-linear-to-br from-violet-50 via-purple-50 to-indigo-50 dark:from-violet-950 dark:via-purple-950 dark:to-indigo-950 transition-colors">
    <!-- Navigation -->
    <nav class="bg-white/10 dark:bg-gray-800/10 backdrop-blur-xl border-b border-violet-200/50 dark:border-violet-800/50 shadow-lg dark:shadow-black/40">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-violet-900 dark:text-white">📦 Inventory System</h1>
                <p class="text-violet-700 dark:text-violet-100 text-sm">Welcome, <span class="font-semibold text-violet-900 dark:text-white">{{ Auth::user()->userid }}</span></p>
            </div>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-violet-600/30 hover:bg-violet-500/40 border-2 border-violet-200/50 dark:border-violet-800/50 dark:bg-violet-600/20 dark:hover:bg-violet-500/30 text-violet-900 dark:text-white px-4 py-2 rounded-lg font-medium transition backdrop-blur-sm">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Header Section -->
        <div class="mb-12">
            <h2 class="text-4xl font-bold text-violet-900 dark:text-white mb-2">Select Your Inventory</h2>
            <p class="text-violet-700 dark:text-violet-100">Choose an active inventory to begin managing your stock</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-500/10 dark:bg-red-500/10 border-2 border-red-200/50 dark:border-red-800/50 rounded-lg backdrop-blur-sm">
                <p class="text-red-700 dark:text-red-300 text-sm font-medium">{{ $errors->first() }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 p-4 bg-red-500/10 dark:bg-red-500/10 border-2 border-red-200/50 dark:border-red-800/50 rounded-lg backdrop-blur-sm">
                <p class="text-red-700 dark:text-red-300 text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Inventories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse ($inventories as $inventory)
                <div class="group {{ $inventory->status === 'active' ? '' : 'opacity-60' }}">
                    <form action="{{ route('inventory.lobby.store') }}" method="POST" class="h-full">
                        @csrf
                        <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">

                        <button
                            type="submit"
                            {{ $inventory->status !== 'active' ? 'disabled' : '' }}
                            class="w-full h-full p-6 rounded-xl transition transform {{ $inventory->status === 'active' ? 'bg-white/10 dark:bg-gray-800/10 border-2 border-violet-200/50 dark:border-violet-800/50 hover:border-violet-300/80 dark:hover:border-violet-700/80 hover:bg-white/20 dark:hover:bg-gray-700/20 hover:shadow-xl dark:hover:shadow-xl hover:shadow-violet-500/20 dark:hover:shadow-violet-500/20 hover:-translate-y-1 cursor-pointer backdrop-blur-xl' : 'bg-white/5 dark:bg-gray-800/5 border-2 border-violet-200/30 dark:border-violet-800/30 cursor-not-allowed backdrop-blur-xl' }} text-left"
                        >
                            <!-- Status Badge -->
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-violet-900 dark:text-white">{{ $inventory->name }}</h3>
                                    @if ($inventory->location)
                                        <p class="text-violet-700 dark:text-violet-100 text-sm mt-1">📍 {{ $inventory->location }}</p>
                                    @endif
                                </div>
                                <div>
                                    @if ($inventory->status === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500/30 dark:bg-green-500/20 text-green-700 dark:text-green-200 border border-green-400/50 dark:border-green-600/50 backdrop-blur-sm">
                                            ✓ Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/30 dark:bg-red-500/20 text-red-700 dark:text-red-200 border border-red-400/50 dark:border-red-600/50 backdrop-blur-sm">
                                            ⊗ Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            @if ($inventory->description)
                                <p class="text-violet-800 dark:text-violet-50 text-sm mb-4 line-clamp-2">{{ $inventory->description }}</p>
                            @endif

                            <!-- Current Selection Indicator -->
                            @if ($inventory->id == $currentInventoryId)
                                <div class="mt-4 pt-4 border-t border-violet-300/30 dark:border-violet-700/30">
                                    <p class="text-amber-700 dark:text-yellow-200 text-sm font-medium">✓ Currently Selected</p>
                                </div>
                            @endif

                            <!-- Access Button (conditional) -->
                            @if ($inventory->status === 'active')
                                <div class="mt-4 inline-block">
                                    <span class="text-amber-700 dark:text-yellow-200 text-sm font-medium group-hover:translate-x-1 inline-block transition">
                                        Access Inventory →
                                    </span>
                                </div>
                            @else
                                <div class="mt-4 pt-4 border-t border-violet-300/30 dark:border-violet-700/30">
                                    <p class="text-orange-700 dark:text-orange-200 text-sm font-medium mb-2">
                                        ⚠️ This inventory is currently inactive
                                    </p>
                                    <p class="text-violet-700 dark:text-violet-50/70 text-xs">
                                        Your access has been temporarily disabled. This may be due to a missed payment or account maintenance. Contact your administrator to reactivate.
                                    </p>
                                </div>
                            @endif
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full p-12 bg-white/10 dark:bg-gray-800/10 border-2 border-violet-200/50 dark:border-violet-800/50 rounded-xl text-center backdrop-blur-xl">
                    <p class="text-violet-900 dark:text-white text-lg mb-4">📭 No inventories assigned</p>
                    <p class="text-violet-700 dark:text-violet-100/70 text-sm">Please contact your administrator to get access to an inventory.</p>
                </div>
            @endforelse
        </div>

        <!-- Support & Information Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Need Help Section -->
            <div class="bg-blue-500/10 dark:bg-blue-500/5 border-2 border-blue-300/50 dark:border-blue-800/50 rounded-xl p-8 backdrop-blur-xl">
                <div class="flex items-start gap-3 mb-4">
                    <div class="text-2xl">❓</div>
                    <h3 class="text-lg font-bold text-violet-900 dark:text-white">Need Help?</h3>
                </div>
                <p class="text-violet-800 dark:text-violet-50/80 text-sm mb-4">
                    Learn how to use the system effectively:
                </p>
                <ul class="text-violet-700 dark:text-violet-100/70 text-sm space-y-2 mb-4">
                    <li>• <strong>Managing Products:</strong> Add, edit, or remove items from your inventory</li>
                    <li>• <strong>Stock Adjustments:</strong> Track inventory movements and stock transfers</li>
                    <li>• <strong>Categories & Suppliers:</strong> Organize your inventory with categories</li>
                    <li>• <strong>Reports:</strong> Generate comprehensive inventory reports</li>
                </ul>
                <a
                    href="https://m.me/101862929192575"
                    class="inline-flex items-center gap-2 bg-blue-600/30 hover:bg-blue-500/40 border-2 border-blue-300/50 dark:border-blue-800/50 text-blue-900 dark:text-white px-4 py-2 rounded-lg font-medium text-sm transition backdrop-blur-sm"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    💬 Chat with Support
                </a>
            </div>

            <!-- Inventory Issues Section -->
            <div class="bg-amber-500/10 dark:bg-amber-500/5 border-2 border-amber-300/50 dark:border-amber-800/50 rounded-xl p-8 backdrop-blur-xl">
                <div class="flex items-start gap-3 mb-4">
                    <div class="text-2xl">🔧</div>
                    <h3 class="text-lg font-bold text-violet-900 dark:text-white">Inventory Issues?</h3>
                </div>
                <p class="text-violet-800 dark:text-violet-50/80 text-sm mb-4">
                    Having trouble with your inventory access?
                </p>
                <ul class="text-violet-700 dark:text-violet-100/70 text-sm space-y-2 mb-4">
                    <li>• <strong>Inactive Inventory:</strong> May indicate a missed payment or account review</li>
                    <li>• <strong>No Inventories:</strong> Request access from your administrator</li>
                    <li>• <strong>Permission Issues:</strong> Contact support for access recovery</li>
                </ul>
                <a
                    href="tel:09935240627"
                    class="inline-flex items-center gap-2 bg-amber-600/30 hover:bg-amber-500/40 border-2 border-amber-300/50 dark:border-amber-800/50 text-amber-900 dark:text-white px-4 py-2 rounded-lg font-medium text-sm transition backdrop-blur-sm"
                >
                    📞 Contact Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-20 py-6 border-t border-violet-200/30 dark:border-violet-800/30 bg-white/5 dark:bg-gray-800/5 backdrop-blur-xl">
        <div class="max-w-6xl mx-auto px-6 text-center text-violet-700 dark:text-violet-100/70 text-sm">
            <p>Inventory Management System &copy; 2025</p>
        </div>
    </footer>
</body>
</html>
