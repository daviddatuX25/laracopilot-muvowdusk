<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Low Stock Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Low Stock Report</h1>
    <p style="text-align: center; color: #666;">Generated on {{ date('Y-m-d H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Current Stock</th>
                <th>Reorder Level</th>
                <th>Category</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->current_stock }}</td>
                    <td>{{ $product->reorder_level }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No low stock products found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
