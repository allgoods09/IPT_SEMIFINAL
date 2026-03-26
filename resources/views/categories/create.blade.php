<x-app-layout>
    <x-slot name="pageTitle">Add Category</x-slot>
    <x-slot name="pageSubtitle">Create a new product category</x-slot>

    <div class="max-w-xl mx-auto">
        <div class="card p-8">

            @if ($errors->any())
                <div class="flash-error mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('categories.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label>Category Name *</label>
                    <input type="text" name="name"
                           placeholder="e.g. Electronics"
                           class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                           value="{{ old('name') }}" required>
                </div>

                <div>
                    <label>Description</label>
                    <textarea name="description" rows="3"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                              placeholder="Brief description…">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status"
                        class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        <option value="active"    {{ old('status', 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive"  {{ old('status') === 'inactive'           ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold">
                        Save Category
                    </button>
                    <a href="{{ route('categories.index') }}"
                       class="px-6 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>