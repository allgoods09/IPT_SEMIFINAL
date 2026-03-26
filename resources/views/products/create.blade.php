<x-app-layout>
    <x-slot name="pageTitle">Add Product</x-slot>
    <x-slot name="pageSubtitle">Create a new inventory item</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card p-8">

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="flash-error mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-2 gap-5">

                    <div class="col-span-2">
                        <label>Product Name *</label>
                        <input 
                            type="text" 
                            name="name"
                            placeholder="e.g. Wireless Mouse"
                            value="{{ old('name') }}" 
                            required
                            autofocus
                            autocomplete="off"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        >
                    </div>

                    <div class="col-span-2">
                        <label>Category</label>
                        <select name="category_id" class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            <option value="">— Select Category —</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label>Description</label>
                        <textarea 
                            name="description" 
                            rows="5"  {{-- make taller --}}
                            placeholder="Optional description..."
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500 resize-none"
                        >{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label>Cost Price (₱) *</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0" 
                            name="cost_price"
                            placeholder="0.00" 
                            value="{{ old('cost_price') }}" 
                            required
                            inputmode="decimal"
                            oninput="formatPrice(this)"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        >
                    </div>

                    <div>
                        <label>Selling Price (₱) *</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0" 
                            name="selling_price"
                            placeholder="0.00" 
                            value="{{ old('selling_price') }}" 
                            required
                            inputmode="decimal"
                            oninput="formatPrice(this)"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        >
                    </div>

                    <div>
                        <label>Stock Quantity *</label>
                        <input 
                            type="number" 
                            min="0" 
                            name="stock_quantity"
                            placeholder="0" 
                            value="{{ old('stock_quantity') }}" 
                            required
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        >
                    </div>

                    <div>
                        <label>Reorder Level *</label>
                        <input 
                            type="number" 
                            min="0" 
                            name="reorder_level"
                            placeholder="10" 
                            value="{{ old('reorder_level') }}" 
                            required
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        >
                    </div>

                    <div>
                        <label>Status</label>
                        <select name="status" class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold">
                        Save Product
                    </button>
                    <a href="{{ route('products.index') }}"
                       class="px-6 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>