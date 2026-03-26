<x-app-layout>
    <x-slot name="pageTitle">Logs</x-slot>
    <x-slot name="pageSubtitle">Manage system activity logs</x-slot>



    <div class="card p-6">

        {{-- Search --}}
        <form method="GET" action="{{ route('logs.index') }}" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" placeholder="Search logs..."
                   value="{{ request('search') ?? '' }}" class="max-w-xs text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500">
            <button type="submit" class="btn-primary px-4 py-2 rounded-xl text-sm font-semibold">
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('logs.index') }}"
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
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">User</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Action</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Entity</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Description</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Created</th>
                        @if (Auth::user()->role === 'Admin')
                            <th class="text-right py-3 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wide">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $i => $log)
                        <tr class="table-row border-b border-slate-50">
                            <td class="py-3 px-4 text-slate-400 font-mono text-xs">{{ $i + 1 }}</td>

                            <td class="py-3 px-4">
                                @if($log->user)
                                    <div class="font-semibold text-slate-800">{{ $log->user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $log->user->email }}</div>
                                @else
                                    <span class="text-slate-500">System</span>
                                @endif
                            </td>

                            <td class="py-3 px-4">
                                <span class="badge-slate text-xs font-semibold px-2.5 py-1 rounded-full">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>

                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1 text-sm font-medium text-slate-700">
                                    <span class="capitalize">{{ $log->entity_type }}</span>
                                    <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">{{ $log->entity_id }}</span>
                                </span>
                            </td>

                            <td class="py-3 px-4 text-slate-500 max-w-xs truncate">
                                {{ $log->description ?: '—' }}
                            </td>

                            <td class="py-3 px-4 text-slate-400 text-xs">
                                {{ $log->created_at ? $log->created_at->format('M d, Y') : 'N/A' }}
                            </td>

                            @if (Auth::user()->role === 'Admin')
                                <td class="py-3 px-4 text-right">
                                    <form method="POST" action="{{ route('logs.destroy', $log) }}"
                                          onsubmit="return confirm('Delete this log?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn-danger text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role === 'Admin' ? '7' : '6' }}" class="py-12 text-center text-slate-400">No logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
