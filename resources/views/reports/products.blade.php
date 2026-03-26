<x-app-layout>
    <x-slot name="pageTitle">Products Report</x-slot>
    <x-slot name="pageSubtitle">Inventory stock levels</x-slot>

    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <!-- Back Button -->
        <div>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Reports
            </a>
        </div>

        <!-- Report Header -->
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Products Report</h2>
            <p class="text-slate-500">Stock snapshot as of {{ \Illuminate\Support\Carbon::parse($month)->format('F Y') }}</p>
        </div>

        <!-- Products Table -->
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Reorder Level</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($data as $product)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 text-right">{{ $product->stock_quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 text-right">{{ $product->reorder_level }}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><center>
                                @if ($product->status !== 'active')
                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Inactive</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                                @endif
                            </center>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Summary & Actions -->
        <div class="flex flex-col lg:flex-row gap-6 bg-slate-50 p-6 rounded-xl shadow justify-between items-center">
            <div class="flex flex-wrap gap-8 text-sm flex-1">
                <div>
                    <div class="text-slate-500">Total Products</div>
                    <div class="font-bold text-2xl text-slate-800">{{ $data->count() }}</div>
                </div>
                <div>
                    <div class="text-slate-500">Low Stock Items</div>
                    <div class="font-bold text-2xl text-red-600">{{ $data->filter(fn($p) => $p->stock_quantity <= $p->reorder_level)->count() }}</div>
                </div>
            </div>
            <div class="flex gap-3 w-full lg:w-auto">
                <a href="{{ route('reports.recipient', ['type' => $type, 'month' => $month]) }}" 
                    class="flex-1 lg:flex-none btn-secondary px-6 py-3 rounded-xl font-semibold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m-4 4l4 4" />
                        </svg>
                        Mail To
                    </a>

                <a href="{{ route('reports.pdf', ['type' => $type, 'month' => $month]) }}" 
                   class="flex-1 lg:flex-none btn-primary px-6 py-3 rounded-xl font-semibold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
