<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventory Summary Report</title>
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
        .summary-box {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <h1>Inventory Summary Report</h1>
    <p style="text-align: center; color: #666;">Generated on {{ date('Y-m-d H:i:s') }}</p>

    <div class="summary-box">
        <div class="summary-row">
            <strong>Total Products:</strong>
            <span>{{ $totalProducts }}</span>
        </div>
        <div class="summary-row">
            <strong>Total Categories:</strong>
            <span>{{ $totalCategories }}</span>
        </div>
        <div class="summary-row">
            <strong>Total Suppliers:</strong>
            <span>{{ $totalSuppliers }}</span>
        </div>
        <div class="summary-row">
            <strong>Total Stock Value:</strong>
            <span>₱{{ number_format($totalStockValue, 2) }}</span>
        </div>
    </div>
</body>
</html>
