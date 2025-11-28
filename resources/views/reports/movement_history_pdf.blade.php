<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Stock Movement History Report</title>
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
    <h1>Stock Movement History Report</h1>
    <p style="text-align: center; color: #666;">Generated on {{ date('Y-m-d H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Movement Type</th>
                <th>Quantity</th>
                <th>Reference</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $movement)
                <tr>
                    <td>{{ $movement->product->name ?? 'N/A' }}</td>
                    <td>{{ $movement->product->sku ?? 'N/A' }}</td>
                    <td>{{ ucfirst($movement->type) }}</td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ $movement->reference ?? 'N/A' }}</td>
                    <td>{{ $movement->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No movement history found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
