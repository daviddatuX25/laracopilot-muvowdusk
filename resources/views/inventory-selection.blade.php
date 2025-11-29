<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Inventory - Inventory System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-linear-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Select Inventory</h1>
                <p class="text-gray-600 mt-2">Welcome, <span class="font-semibold">{{ Auth::user()->userid }}</span></p>
                <p class="text-gray-500 text-sm mt-1">Choose which inventory to work with</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 text-sm">{{ $errors->first() }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('inventory.lobby.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-3">
                    @forelse ($inventories as $inventory)
                        <label class="flex items-center p-4 border-2 {{ $inventory->id == $currentInventoryId ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition">
                            <input
                                type="radio"
                                name="inventory_id"
                                value="{{ $inventory->id }}"
                                class="w-4 h-4 text-blue-600"
                                {{ $inventory->id == $currentInventoryId ? 'checked' : '' }}
                                required
                            >
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-900">{{ $inventory->name }}</p>
                                @if ($inventory->location)
                                    <p class="text-sm text-gray-600">📍 {{ $inventory->location }}</p>
                                @endif
                                @if ($inventory->description)
                                    <p class="text-sm text-gray-500">{{ Str::limit($inventory->description, 60) }}</p>
                                @endif
                            </div>
                            <div class="ml-4">
                                @if ($inventory->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </label>
                    @empty
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800">No active inventories available. Please contact your administrator.</p>
                        </div>
                    @endforelse
                </div>

                @if ($inventories->isNotEmpty())
                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition mt-6"
                    >
                        Continue to Dashboard
                    </button>
                @endif

                <div class="text-center mt-6">
                    <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 font-medium underline">
                            Logout
                        </button>
                    </form>
                </div>
            </form>
        </div>

        <div class="mt-6 text-center">
            <p class="text-white text-sm">Inventory Management System</p>
        </div>
    </div>
</body>
</html>

