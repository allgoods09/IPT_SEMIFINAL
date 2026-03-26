<x-app-layout>
    <x-slot name="pageTitle">Products</x-slot>
    <x-slot name="pageSubtitle">Manage your inventory items</x-slot>

    @if (Auth::user()->role === 'Admin')
        <x-slot name="headerAction">
            <a href="{{ route('products.create') }}"
               class="btn-primary px-4 py-2 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Product
            </a>
        </x-slot>
    @endif

    {{-- Flash messages --}}
    @if (session('msg'))
        <div id="flash-message" class="mb-5 flash-{{ session('msg') === 'deleted' ? 'error' : 'success' }}">
            {{ session('msg') === 'saved' ? '✓ Product saved.' : '✓ Product deleted.' }}
        </div>
    @endif

    <div class="card p-6">
        {{-- Filters --}}
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" placeholder="Search products..."
                   value="{{ $search }}" class="max-w-xs text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">

            <select name="category" style="width:auto; padding:10px 14px;">
                <option value="">All Categories</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" {{ $catFilter == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-primary px-4 py-2 rounded-xl text-sm font-semibold">
                Filter
            </button>

            @if ($search || $catFilter)
                <a href="{{ route('products.index') }}"
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
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Category</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Cost</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Price</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Stock</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Status</th>
                        @if (Auth::user()->role === 'Admin')
                            <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $i => $p)
                        <tr class="table-row border-b border-slate-50">
                            <td class="py-3 px-4 text-slate-400 font-mono text-xs">{{ $p->id }}</td>

                            <td class="py-3 px-4">
                                <div class="font-semibold text-slate-800">{{ $p->name }}</div>
                                @if ($p->description)
                                    <div class="text-xs text-slate-400 truncate max-w-xs">{{ $p->description }}</div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-slate-500">
                                {{ $p->category->name ?? '—' }}
                            </td>

                            <td class="py-3 px-4 text-right text-slate-500">
                                ₱{{ number_format($p->cost_price, 2) }}
                            </td>

                            <td class="py-3 px-4 text-right font-semibold text-slate-800">
                                ₱{{ number_format($p->selling_price, 2) }}
                            </td>

                            <td class="py-3 px-4 text-right">
                                <span class="font-bold {{ $p->stock_quantity <= $p->reorder_level ? 'text-red-500' : 'text-slate-800' }}">
                                    {{ $p->stock_quantity }}
                                </span>
                                <span class="text-xs text-slate-400"> / {{ $p->reorder_level }}</span>
                            </td>

                            <td class="py-3 px-4">
                                <span class="badge-{{ strtolower($p->status) }} text-xs font-semibold px-2.5 py-1 rounded-full">
                                    {{ $p->status }}
                                </span>
                            </td>

                            @if (Auth::user()->role === 'Admin')
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('products.edit', $p) }}"
                                           class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('products.destroy', $p) }}"
                                              onsubmit="return confirm('Delete this product?')">
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
                            <td colspan="8" class="py-12 text-center text-slate-400">No products found.</td>
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
        }, 1500); // 3 seconds
    </script>
</x-app-layout>