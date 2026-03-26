<x-app-layout>
    <x-slot name="pageTitle">{{ $category->name }}</x-slot>
    <x-slot name="pageSubtitle">Category details</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card p-8">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-400 to-slate-500 flex items-center justify-center text-2xl font-bold text-white mb-4 shadow-lg">
                            {{ substr($category->name, 0, 2) }}
                        </div>
                        <h1 class="text-3xl font-bold text-slate-800">{{ $category->name }}</h1>
                        <p class="text-sm text-slate-500 mt-1">Created {{ $category->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('categories.edit', $category) }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-semibold text-slate-700 mb-4">Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-slate-500">Status</label>
                                <div>
                                    @if($category->status === 'active')
                                        <span class="inline-flex px-3 py-1 text-sm font-bold rounded-full badge-active">Active</span>
                                    @else
                                        <span class="inline-flex px-3 py-1 text-sm font-bold rounded-full badge-inactive">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            @if($category->description)
                                <div>
                                    <label class="text-sm font-medium text-slate-500">Description</label>
                                    <div class="text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $category->description }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-700 mb-4">Stats</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-slate-500">Total Products</label>
                                <div class="text-2xl font-bold text-slate-800">{{ $category->products()->count() }}</div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500">Active Products</label>
                                <div class="text-2xl font-bold" style="color:#16b36e;">{{ $category->products()->where('status', 'active')->count() }}</div>
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
                    <a href="{{ route('categories.edit', $category) }}" class="w-full block btn-primary px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Category
                    </a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $category->name }}?')" class="w-full btn-danger px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Category
                        </button>
                    </form>
                    <a href="{{ route('categories.index') }}" class="w-full block text-sm font-medium text-slate-600 hover:text-slate-800 text-center py-3 px-4 rounded-xl hover:bg-slate-100 transition">
                        ← Back to Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
