<x-app-layout>
    <x-slot name="pageTitle">Categories</x-slot>
    <x-slot name="pageSubtitle">Manage product categories</x-slot>

    @if (Auth::user()->role === 'Admin')
        <x-slot name="headerAction">
            <a href="{{ route('categories.create') }}"
               class="btn-primary px-4 py-2 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Category
            </a>
        </x-slot>
    @endif

    {{-- Flash messages --}}
    @if (session('msg'))
        <div id="flash-message" class="mb-5 flash-{{ session('msg') === 'deleted' ? 'error' : 'success' }}">
            {{ session('msg') === 'saved' ? '✓ Category saved successfully.' : '✓ Category deleted.' }}
        </div>
    @endif

    <div class="card p-6">

        {{-- Search --}}
        <form method="GET" action="{{ route('categories.index') }}" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" placeholder="Search categories..."
                   value="{{ $search }}" class="max-w-xs text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">

            <button type="submit" class="btn-primary px-4 py-2 rounded-xl text-sm font-semibold">
                Search
            </button>

            @if ($search)
                <a href="{{ route('categories.index') }}"
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
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Name</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Description</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Created</th>
                        @if (Auth::user()->role === 'Admin')
                            <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $i => $cat)
                        <tr class="table-row border-b border-slate-50">
                            <td class="py-3 px-4 text-slate-400 font-mono text-xs">{{ $cat->id }}</td>

                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $cat->name }}</td>

                            <td class="py-3 px-4 text-slate-500 max-w-xs truncate">
                                {{ $cat->description ?: '—' }}
                            </td>

                            <td class="py-3 px-4">
                                <span class="badge-{{ strtolower($cat->status) }} text-xs font-semibold px-2.5 py-1 rounded-full">
                                    {{ $cat->status }}
                                </span>
                            </td>

                            <td class="py-3 px-4 text-slate-400 text-xs">
                                {{ optional($cat->created_at)->format('M d, Y') ?? 'N/A' }}
                            </td>

                            @if (Auth::user()->role === 'Admin')
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('categories.edit', $cat) }}"
                                           class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('categories.destroy', $cat) }}"
                                              onsubmit="return confirm('Deactivate this category?')">
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
                            <td colspan="6" class="py-12 text-center text-slate-400">No categories found.</td>
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