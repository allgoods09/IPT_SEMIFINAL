<x-app-layout>
    <x-slot name="pageTitle">Edit Category</x-slot>
    <x-slot name="pageSubtitle">Update category details</x-slot>

    <div class="max-w-xl mx-auto">
        <div class="card p-8">

            @if ($errors->any())
                <div class="flash-error mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label>Category Name *</label>
                    <input type="text" name="name"
                           class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                           value="{{ old('name', $category->name) }}" required>
                </div>

                <div>
                    <label>Description</label>
                    <textarea name="description" rows="3"
                            class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                              placeholder="Brief description…">{{ old('description', $category->description) }}</textarea>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status"
                        class="w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                        <option value="active"   {{ old('status', $category->status) === 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold">
                        Update Category
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