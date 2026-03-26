<x-app-layout>
    <x-slot name="pageTitle">Sales</x-slot>
    <x-slot name="pageSubtitle">Transaction history</x-slot>

    @if (Auth::user()->role === 'Admin')
        <x-slot name="headerAction">
            <a href="{{ route('sales.create') }}"
               class="btn-primary px-4 py-2 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Sale
            </a>
        </x-slot>
    @endif

    {{-- Flash messages --}}
    @if (session('msg'))
        <div id="flash-message" class="mb-5 flash-{{ session('msg') === 'deleted' ? 'error' : 'success' }}">
            {{ session('msg') === 'saved' ? '✓ Sale recorded successfully.' : (session('msg') === 'updated' ? '✓ Sale updated.' : '✓ Sale deleted and stock restored.') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div class="card p-5">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Total Revenue</div>
            <div class="text-2xl font-bold text-slate-800">₱{{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="card p-5">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Total Transactions</div>
            <div class="text-2xl font-bold text-slate-800">{{ $totalSales }}</div>
        </div>
        <div class="card p-5">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wide mb-1">Avg. Sale Value</div>
            <div class="text-2xl font-bold text-slate-800">₱{{ number_format($avgSaleValue, 2) }}</div>
        </div>
    </div>

    <div class="card p-6">
        {{-- Search --}}
        <form method="GET" action="{{ route('sales.index') }}" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" placeholder="Search by product…"
                   value="{{ $search }}" class="max-w-xs text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                   

            <button type="submit" class="btn-primary px-4 py-2 rounded-xl text-sm font-semibold">
                Search
            </button>

            @if ($search)
                <a href="{{ route('sales.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                    Clear
                </a>
            @endif
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-100">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">#</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Product</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Qty</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Unit Price</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Total</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Payment</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Date</th>
                        @if (Auth::user()->role === 'Admin')
                            <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $i => $s)
                        <tr class="table-row border-b border-slate-50">
                            <td class="py-3 px-4 text-slate-400 font-mono text-xs">{{ $s->id }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $s->product->name }}</td>
                            <td class="py-3 px-4 text-right text-slate-600">{{ $s->quantity }}</td>
                            <td class="py-3 px-4 text-right text-slate-500">₱{{ number_format($s->price, 2) }}</td>
                            <td class="py-3 px-4 text-right font-bold text-slate-800">₱{{ number_format($s->total_amount, 2) }}</td>
                            <td class="py-3 px-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
                                    {{ ucfirst($s->payment_method) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 text-xs">
                                {{ optional($s->sale_date)->format('M d, Y H:i') ?? 'N/A' }}
                            </td>                            @if (Auth::user()->role === 'Admin')
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('sales.edit', $s) }}"
                                           class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('sales.destroy', $s) }}" method="POST" 
                                            onsubmit="return confirm('Delete this sale? Stock will be restored.')" 
                                            class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn-danger text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role === 'Admin' ? '8' : '7' }}" class="py-12 text-center text-slate-400">No sales recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = "0";
                
                setTimeout(() => flash.remove(), 500); // remove after fade
            }
        }, 1500); // 1.5 seconds
    </script>
</x-app-layout>
