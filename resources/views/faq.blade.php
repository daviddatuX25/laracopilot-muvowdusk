@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Frequently Asked Questions</h1>
        <p class="mt-2 text-lg text-gray-600">Find answers to common questions about our inventory system.</p>
    </div>

    <!-- FAQ Items -->
    <div class="space-y-6">
        <!-- Question 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">How do I add a new product?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>To add a new product:</p>
                <ol class="list-decimal list-inside mt-2 space-y-2">
                    <li>Click on the "Products" menu item in the navigation</li>
                    <li>Click the "Create Product" button</li>
                    <li>Fill in the product details including name, SKU, price, and category</li>
                    <li>Optionally upload a product image</li>
                    <li>Click "Create" to save the product</li>
                </ol>
                <p class="mt-3 text-sm text-gray-600">The system will automatically generate a unique barcode for your product.</p>
            </div>
        </div>

        <!-- Question 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">What is the Barcode Scanner used for?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>The Barcode Scanner allows you to quickly look up products using your device's camera. It reads barcodes and QR codes to instantly display product information such as:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Product name and SKU</li>
                    <li>Current stock level</li>
                    <li>Product category and supplier</li>
                    <li>Product image and pricing</li>
                </ul>
                <p class="mt-3 text-sm text-gray-600">If the camera doesn't work on your device, you can manually enter the SKU or barcode as a fallback option.</p>
            </div>
        </div>

        <!-- Question 3 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">How do I adjust stock levels?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>To adjust stock levels:</p>
                <ol class="list-decimal list-inside mt-2 space-y-2">
                    <li>Go to "Stock Movements" from the main menu</li>
                    <li>Use the barcode scanner to find the product or manually search for it</li>
                    <li>Enter the adjustment quantity and select the movement type (In/Out/Adjustment)</li>
                    <li>Provide a reason for the adjustment</li>
                    <li>Click "Adjust Stock" to record the movement</li>
                </ol>
                <p class="mt-3 text-sm text-gray-600">All stock movements are logged and cannot be negated below zero unless approved as a manual adjustment.</p>
            </div>
        </div>

        <!-- Question 4 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">What are alerts and how do they work?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>Alerts are notifications triggered when a product's stock level falls below its reorder level or reaches zero. The system automatically:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Creates an alert when stock is low</li>
                    <li>Displays pending alerts in the Alerts section</li>
                    <li>Allows you to manually resolve alerts once the issue is addressed</li>
                </ul>
                <p class="mt-3 text-sm text-gray-600">Alerts remain pending until you manually resolve them. They do not automatically disappear when stock is replenished.</p>
            </div>
        </div>

        <!-- Question 5 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">How do I generate reports?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>Several reports are available to help you analyze your inventory:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li><strong>Summary Report:</strong> Overview of total products, categories, and suppliers</li>
                    <li><strong>Low Stock Report:</strong> Products below their reorder level</li>
                    <li><strong>Movement History:</strong> Complete log of all stock movements with dates and reasons</li>
                    <li><strong>Full Inventory:</strong> Complete list of all products with current stock levels</li>
                </ul>
                <p class="mt-3 text-sm text-gray-600">All reports can be exported to PDF format for sharing or archival purposes.</p>
            </div>
        </div>

        <!-- Question 6 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">Can I edit or delete products?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>Yes, you can modify products and categories:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Click the edit button next to any product or category to modify its details</li>
                    <li>Changes take effect immediately</li>
                    <li>Delete functionality is available but should be used with caution as it affects historical data</li>
                    <li>Consider deactivating or archiving instead of permanently deleting</li>
                </ul>
            </div>
        </div>

        <!-- Question 7 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">How do I manage suppliers?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>To manage suppliers:</p>
                <ol class="list-decimal list-inside mt-2 space-y-2">
                    <li>Go to the "Suppliers" section from the main menu</li>
                    <li>View all active suppliers with their contact information</li>
                    <li>Create new suppliers by clicking "Create Supplier"</li>
                    <li>Edit existing supplier details as needed</li>
                    <li>Products can be linked to suppliers for easy reference</li>
                </ol>
            </div>
        </div>

        <!-- Question 8 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">Is my data automatically backed up?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>The system uses a local database (SQLite or MySQL) to store your inventory data. For backup purposes:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Regular manual backups are recommended</li>
                    <li>Back up your database file regularly</li>
                    <li>Keep multiple copies of important data</li>
                    <li>Consider using automated backup solutions for your server</li>
                </ul>
                <p class="mt-3 text-sm text-gray-600">The system does not provide automatic cloud backups. You are responsible for implementing your backup strategy.</p>
            </div>
        </div>

        <!-- Question 9 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">What should I do if the barcode scanner isn't working?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>If the barcode scanner isn't functioning:</p>
                <ol class="list-decimal list-inside mt-2 space-y-2">
                    <li>Check that your browser has camera permissions enabled</li>
                    <li>Try using Chrome or Firefox for best compatibility</li>
                    <li>Ensure the barcode is clearly visible and well-lit</li>
                    <li>Use the manual input field as a fallback by entering the SKU directly</li>
                    <li>Clear your browser cache and refresh the page</li>
                </ol>
                <p class="mt-3 text-sm text-gray-600">Camera support varies by device and browser. Mobile devices and newer browsers generally provide better support.</p>
            </div>
        </div>

        <!-- Question 10 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50 border-l-4 border-indigo-600">
                <h2 class="text-lg font-semibold text-gray-900">Can multiple users access the system simultaneously?</h2>
            </div>
            <div class="px-6 py-4 text-gray-700">
                <p>This inventory system is designed for single-user deployments:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Multiple simultaneous users are not officially supported</li>
                    <li>Best performance is achieved with one user at a time</li>
                    <li>The system uses transactions to maintain data consistency</li>
                    <li>For multi-user environments, consider enterprise solutions with role-based access</li>
                </ul>
                <p class="mt-3 text-sm text-gray-600">Contact the development team for information about future multi-user support.</p>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="mt-12 bg-indigo-50 rounded-lg p-8 border border-indigo-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Still have questions?</h2>
        <p class="text-gray-700 mb-4">
            If you can't find the answer you're looking for, please contact our support team or check the documentation for more detailed information.
        </p>
        <a href="{{ route('about') }}" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
            Learn About Our Team
        </a>
    </div>
</div>
@endsection
