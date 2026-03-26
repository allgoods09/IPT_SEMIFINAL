<x-app-layout>
    <x-slot name="pageTitle">Sale #{{ $sale->id }}</x-slot>
    <x-slot name="pageSubtitle">Transaction details</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card p-8">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-500 flex items-center justify-center text-2xl font-bold text-white mb-4 shadow-lg">
                            #{{ str_pad($sale->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                        <h1 class="text-3xl font-bold text-slate-800">Sale #{{ $sale->id }}</h1>
                        <p class="text-slate-500 mt-1">{{ $sale->sale_date->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('sales.edit', $sale) }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-slate-50 rounded-2xl p-6">
                        <h3 class="font-semibold text-slate-700 mb-4">Order Items</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-b-0">
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $sale->product->name }}</div>
                                    <div class="text-sm text-slate-500">ID: {{ $sale->product_id }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-mono text-lg">{{ $sale->quantity }} × ₱{{ number_format($sale->price, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <h3 class="font-semibold text-slate-700 mb-4">Pricing</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Unit Price</span>
                                    <span class="font-mono font-semibold">₱{{ number_format($sale->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between pt-2 border-t border-slate-100">
                                    <span class="text-xl font-bold text-slate-800">Total</span>
                                    <span class="text-2xl font-bold" style="color:#16b36e;">₱{{ number_format($sale->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-700 mb-4">Payment</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="inline-flex px-3 py-1 text-sm font-bold rounded-full bg-slate-100 text-slate-700 capitalize">
                                        {{ $sale->payment_method }}
                                    </span>
                                </div>
                                <div class="text-sm text-slate-500">
                                    Recorded on {{ $sale->sale_date->format('M d, Y h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card p-6 sticky top-8">
                <h3 class="font-bold text-slate-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('sales.edit', $sale) }}" class="w-full block btn-primary px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Sale
                    </a>
                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this sale?')" class="w-full btn-danger px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Sale
                        </button>
                    </form>
                    <a href="{{ route('sales.index') }}" class="w-full block text-sm font-medium text-slate-600 hover:text-slate-800 text-center py-3 px-4 rounded-xl hover:bg-slate-100 transition">
                        ← Back to Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
