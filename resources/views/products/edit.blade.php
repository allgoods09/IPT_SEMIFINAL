<x-app-layout>
    <x-slot name="pageTitle">Edit Product</x-slot>
    <x-slot name="pageSubtitle">Update product details</x-slot>

    <div class="max-w-xl mx-auto">
        <div class="card p-8">

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="flash-error mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label>Product Name *</label>
                    <input type="text" name="name"
                           value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                </div>

                <div>
                    <label>Category</label>
                    <select name="category_id" 
                    class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                    >
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}"
                                {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Description</label>
                    <textarea name="description" rows="3"
                    class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                    >{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Cost Price (₱)</label>
                        <input type="number" name="cost_price" step="0.01" min="0"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                               value="{{ old('cost_price', $product->cost_price) }}">
                    </div>
                    <div>
                        <label>Selling Price (₱)</label>
                        <input type="number" name="selling_price" step="0.01" min="0"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                               value="{{ old('selling_price', $product->selling_price) }}">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label>Stock Quantity</label>
                        <input type="number" name="stock_quantity" min="0"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                               value="{{ old('stock_quantity', $product->stock_quantity) }}">
                    </div>
                    <div>
                        <label>Reorder Level</label>
                        <input type="number" name="reorder_level" min="0"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                               value="{{ old('reorder_level', $product->reorder_level) }}">
                    </div>
                    <div>
                        <label>Status</label>
                        <select name="status" 
                        class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                        >
                            <option value="active"   {{ old('status', $product->status) === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold">
                        Update Product
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