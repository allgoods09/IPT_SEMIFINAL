<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Logs Report</title>

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
    color: white;
    padding: 10px;
    font-size: 11px;
    text-transform: uppercase;
}

td {
    padding: 10px;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: top;
    text-align: center;
}

tr:nth-child(even) { background: #f8fafc; }

.message {
    max-width: 250px;
    word-wrap: break-word;
    text-align: left;
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
    <h2>Logs Report</h2>
    <p>{{ \Illuminate\Support\Carbon::parse($month)->format('F Y') }}</p>
    <p>Generated on {{ now()->format('M d, Y H:i') }}</p>
</div>

<div class="divider"></div>

<table>
<thead>
<tr>
    <th>Date</th>
    <th>User</th>
    <th>Action</th>
    <th>Entity</th>
    <th>ID</th>
    <th>Description</th>
</tr>
</thead>

<tbody>
@forelse ($data as $log)
<tr>
    <td>{{ $log->created_at->format('M d, Y H:i') ?? 'N/A' }}</td>
    <td>{{ $log->user?->name ?? 'System' }}</td>
    <td>{{ $log->action ?? 'N/A' }}</td>
    <td>{{ $log->entity_type ?? 'N/A' }}</td>
    <td>{{ $log->entity_id ?? 'N/A' }}</td>
    <td class="message">{{ $log->description ?? 'N/A' }}</td>
</tr>
@empty
<tr>
    <td colspan="6" style="text-align:center;color:#94a3b8;">No logs found.</td>
</tr>
@endforelse
</tbody>
</table>

<div class="summary">
    Total Logs: {{ $data->count() }}
</div>

<div class="footer">
    StockFlow Inventory System • Generated Report
</div>

</body>
</html>