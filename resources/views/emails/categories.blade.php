<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Categories Report</title>

<style>
body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 12px;
    margin: 30px;
    color: #091a2a;
}

.header { text-align: center; margin-bottom: 20px; }
.header h1 {
            margin: 0;
            font-size: 20px;
            color: #091a2a;
        }

        .header h2 {
            margin: 4px 0;
            font-size: 15px;
            font-weight: normal;
            color: #009d57;
        }
.header p { margin: 2px 0; font-size: 11px; color: #64748b; }

.divider {
    height: 3px;
    background: #009d57;
    margin: 15px 0 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #091a2a;
    color: #fff;
    padding: 10px;
    font-size: 11px;
    text-transform: uppercase;
}

td {
    padding: 10px;
    border-bottom: 1px solid #e2e8f0;
}

tr:nth-child(even) { background: #f8fafc; }

.amount {
    text-align: right;
    font-weight: 600;
}

.summary {
    margin-top: 20px;
    padding: 14px;
    border-left: 5px solid #009d57;
    background: #f8fafc;
}

.footer {
    margin-top: 30px;
    text-align: right;
    font-size: 10px;
    color: #94a3b8;
}
</style>
</head>

<body>

<div class="header">
    <h1>StockFlow Inventory System</h1>
    <h2>Categories Report</h2>
    <p>{{ \Illuminate\Support\Carbon::parse($month)->format('F Y') }}</p>
    <p>Generated on {{ now()->format('M d, Y H:i') }}</p>
</div>

<div class="divider"></div>

<table>
<thead>
<tr>
    <th>Category</th>
    <th class="amount">Products</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
@forelse ($data as $category)
<tr>
    <td>{{ $category->name }}</td>
    <td class="amount">{{ $category->products_count }}</td>
    <td>{{ $category->status ?? 'N/A' }}</td>
</tr>
@empty
<tr>
    <td colspan="3" style="text-align:center;color:#94a3b8;">No categories found.</td>
</tr>
@endforelse
</tbody>
</table>

<div class="summary">
    Total: {{ $data->count() }} |
    Active: {{ $data->where('status', 'active')->count() }} |
    Empty: {{ $data->where('products_count', 0)->count() }}
</div>

<div class="footer">
    StockFlow Inventory System • Generated Report
</div>

</body>
</html>