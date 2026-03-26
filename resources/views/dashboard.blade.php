<x-app-layout>
    <x-slot name="pageTitle">Dashboard</x-slot>
    <x-slot name="pageSubtitle">Welcome back, {{ Auth::user()->name }}</x-slot>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @php
        $stats = [
            ['Revenue',   '₱' . number_format($totalRevenue, 2), 'Total earnings',    '#16b36e', 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
            ['Products',  $totalProducts,                         'Active products',   '#3b82f6', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['Sales',     $totalSales,                            'Total transactions','#8b5cf6', 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
            ['Low Stock', $lowStock,                              'Need reorder',      '#f59e0b', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
        ];
        @endphp

        @foreach ($stats as [$label, $value, $sub, $color, $icon])
        <div class="card p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:{{ $color }}20;">
                    <svg class="w-5 h-5" style="color:{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-800">{{ $value }}</div>
            <div class="text-sm font-semibold text-slate-700 mt-1">{{ $label }}</div>
            <div class="text-xs text-slate-400 mt-0.5">{{ $sub }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Recent Sales --}}
        <div class="card p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-slate-800">Recent Sales</h2>
                <a href="#" class="text-sm font-medium" style="color:#16b36e;">View all →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left py-2 pb-3 text-xs font-semibold text-slate-400 uppercase tracking-wide">Product</th>
                            <th class="text-right py-2 pb-3 text-xs font-semibold text-slate-400 uppercase tracking-wide">Qty</th>
                            <th class="text-right py-2 pb-3 text-xs font-semibold text-slate-400 uppercase tracking-wide">Total</th>
                            <th class="text-right py-2 pb-3 text-xs font-semibold text-slate-400 uppercase tracking-wide">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentSales as $sale)
                        <tr class="table-row border-b border-slate-50">
                            <td class="py-3 font-medium text-slate-700">{{ $sale->product_name }}</td>
                            <td class="py-3 text-right text-slate-500">{{ $sale->quantity }}</td>
                            <td class="py-3 text-right font-semibold text-slate-800">₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td class="py-3 text-right text-slate-400 text-xs">{{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">No sales recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Low Stock Alert --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-slate-800">Low Stock Alert</h2>
                @if ($lowStock > 0)
                <span class="text-xs font-bold px-2 py-1 rounded-full" style="background:#fef3c7; color:#d97706;">{{ $lowStock }} items</span>
                @endif
            </div>

            @forelse ($lowStockProducts as $product)
            <div class="flex items-center justify-between py-3 border-b border-slate-50">
                <div>
                    <div class="text-sm font-semibold text-slate-700">{{ $product->name }}</div>
                    <div class="text-xs text-slate-400">{{ $product->category_name ?? 'Uncategorized' }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold" style="color:#dc2626;">{{ $product->stock_quantity }}</div>
                    <div class="text-xs text-slate-400">/ {{ $product->reorder_level }} min</div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-slate-400 text-sm">All products are sufficiently stocked. ✓</div>
            @endforelse
        </div>

    </div>

</x-app-layout>