<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Lobby - Inventory System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen" style="background: linear-gradient(135deg, rgba(20, 10, 40, 0.95) 0%, rgba(30, 15, 50, 0.95) 100%), #0a0a0a; background-blend-mode: overlay;">
    <!-- Navigation -->
    <nav class="bg-slate-950 border-b border-slate-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">📦 Inventory System</h1>
                <p class="text-slate-400 text-sm">Welcome, <span class="font-semibold text-slate-300">{{ Auth::user()->userid }}</span></p>
            </div>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Header Section -->
        <div class="mb-12">
            <h2 class="text-4xl font-bold text-white mb-2">Select Your Inventory</h2>
            <p class="text-slate-400">Choose an active inventory to begin managing your stock</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-900/20 border border-red-500 rounded-lg">
                <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 p-4 bg-red-900/20 border border-red-500 rounded-lg">
                <p class="text-red-400 text-sm">{{ session('error') }}</p>
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
                            class="w-full h-full p-6 rounded-xl transition transform {{ $inventory->status === 'active' ? 'bg-slate-700/40 border-2 border-slate-600 hover:border-blue-500 hover:bg-slate-700/60 hover:shadow-lg hover:shadow-blue-500/20 hover:-translate-y-1 cursor-pointer' : 'bg-slate-800/40 border-2 border-slate-700 cursor-not-allowed' }} text-left"
                        >
                            <!-- Status Badge -->
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ $inventory->name }}</h3>
                                    @if ($inventory->location)
                                        <p class="text-slate-400 text-sm mt-1">📍 {{ $inventory->location }}</p>
                                    @endif
                                </div>
                                <div>
                                    @if ($inventory->status === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-300 border border-green-500/30">
                                            ✓ Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-300 border border-red-500/30">
                                            ⊗ Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            @if ($inventory->description)
                                <p class="text-slate-300 text-sm mb-4 line-clamp-2">{{ $inventory->description }}</p>
                            @endif

                            <!-- Current Selection Indicator -->
                            @if ($inventory->id == $currentInventoryId)
                                <div class="mt-4 pt-4 border-t border-slate-600">
                                    <p class="text-blue-400 text-sm font-medium">✓ Currently Selected</p>
                                </div>
                            @endif

                            <!-- Access Button (conditional) -->
                            @if ($inventory->status === 'active')
                                <div class="mt-4 inline-block">
                                    <span class="text-blue-400 text-sm font-medium group-hover:translate-x-1 inline-block transition">
                                        Access Inventory →
                                    </span>
                                </div>
                            @else
                                <div class="mt-4 pt-4 border-t border-slate-600">
                                    <p class="text-amber-400 text-sm font-medium mb-2">
                                        ⚠️ This inventory is currently inactive
                                    </p>
                                    <p class="text-slate-400 text-xs">
                                        Your access has been temporarily disabled. This may be due to a missed payment or account maintenance. Contact your administrator to reactivate.
                                    </p>
                                </div>
                            @endif
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full p-12 bg-slate-700/20 border-2 border-slate-600 rounded-xl text-center">
                    <p class="text-slate-400 text-lg mb-4">📭 No inventories assigned</p>
                    <p class="text-slate-500 text-sm">Please contact your administrator to get access to an inventory.</p>
                </div>
            @endforelse
        </div>

        <!-- Support & Information Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Need Help Section -->
            <div class="bg-blue-900/20 border border-blue-600/30 rounded-xl p-8">
                <div class="flex items-start gap-3 mb-4">
                    <div class="text-2xl">❓</div>
                    <h3 class="text-lg font-bold text-white">Need Help?</h3>
                </div>
                <p class="text-slate-300 text-sm mb-4">
                    Learn how to use the system effectively:
                </p>
                <ul class="text-slate-400 text-sm space-y-2 mb-4">
                    <li>• <strong>Managing Products:</strong> Add, edit, or remove items from your inventory</li>
                    <li>• <strong>Stock Adjustments:</strong> Track inventory movements and stock transfers</li>
                    <li>• <strong>Categories & Suppliers:</strong> Organize your inventory with categories</li>
                    <li>• <strong>Reports:</strong> Generate comprehensive inventory reports</li>
                </ul>
                <a
                    href="https://www.messenger.com/t/9713939975319492/ "
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    💬 Chat with Support
                </a>
            </div>

            <!-- Inventory Issues Section -->
            <div class="bg-amber-900/20 border border-amber-600/30 rounded-xl p-8">
                <div class="flex items-start gap-3 mb-4">
                    <div class="text-2xl">🔧</div>
                    <h3 class="text-lg font-bold text-white">Inventory Issues?</h3>
                </div>
                <p class="text-slate-300 text-sm mb-4">
                    Having trouble with your inventory access?
                </p>
                <ul class="text-slate-400 text-sm space-y-2 mb-4">
                    <li>• <strong>Inactive Inventory:</strong> May indicate a missed payment or account review</li>
                    <li>• <strong>No Inventories:</strong> Request access from your administrator</li>
                    <li>• <strong>Permission Issues:</strong> Contact support for access recovery</li>
                </ul>
                <a
                    href="tel:09935240627"
                    class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition"
                >
                    📞 Contact Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-20 py-6 border-t border-slate-700">
        <div class="max-w-6xl mx-auto px-6 text-center text-slate-500 text-sm">
            <p>Inventory Management System &copy; 2025</p>
        </div>
    </footer>
</body>
</html>
