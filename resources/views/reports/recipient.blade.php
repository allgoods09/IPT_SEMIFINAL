<x-app-layout>
    <x-slot name="pageTitle">Send Report</x-slot>
    <x-slot name="pageSubtitle">Select recipients for {{ ucfirst($type) }} Report</x-slot>

    <div class="max-w-3xl mx-auto p-6 space-y-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('reports.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Reports
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Recipient Form -->
        <div class="bg-white shadow rounded-xl p-6">
            <form action="{{ route('reports.mail', ['type' => $type, 'month' => $month]) }}" method="POST" required>
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Recipients</label>

                    <!-- Actions -->
                    <div class="flex items-center gap-3 px-4 py-3 mb-2">
                        <input 
                            type="checkbox" 
                            id="select-all"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 shrink-0"
                            onchange="toggleAll(this.checked)"
                        >
                        <label for="select-all" class="text-sm font-medium text-slate-700 cursor-pointer">
                            Select All
                        </label>
                    </div>

                    <!-- Checkbox List -->
                    <div class="border rounded-xl overflow-hidden bg-white">
                        <div class="max-h-64 overflow-y-auto divide-y">

                            @foreach ($users as $user)
                                <label class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 cursor-pointer">
                                    
                                    <!-- Checkbox -->
                                    <input 
                                        type="checkbox" 
                                        name="recipients[]" 
                                        value="{{ $user->email }}"
                                        class="recipient-checkbox h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 shrink-0"
                                    >

                                    <!-- User Info -->
                                    <div class="flex flex-col leading-tight">
                                        <span class="text-sm font-medium text-slate-800">
                                            {{ $user->name }}
                                        </span>
                                        <span class="text-xs text-slate-500">
                                            {{ $user->email }}
                                        </span>
                                    </div>

                                </label>
                            @endforeach

                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center mt-6">
                    <!-- Send to All -->
                    <button type="submit" name="send_all" value="1"
                        class="px-5 py-2 rounded-xl bg-emerald-500 text-white font-semibold hover:bg-emerald-600 transition shadow">
                        Send to All
                    </button>

                    <!-- Send Selected -->
                    <button 
                        type="submit" 
                        id="send-selected-btn"
                        disabled
                        class="btn-primary px-6 py-3 rounded-xl font-semibold flex items-center gap-2 shadow-lg transition-all opacity-50 cursor-not-allowed">
                        
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m-4 4l4 4" />
                        </svg>
                        Send Selected
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const checkboxes = document.querySelectorAll('.recipient-checkbox');
        const sendBtn = document.getElementById('send-selected-btn');
        const selectAll = document.getElementById('select-all');

        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = "0";
                
                setTimeout(() => flash.remove(), 500); // remove after fade
            }
        }, 1500); // 3 seconds


        function updateSendButton() {
            const checked = document.querySelectorAll('.recipient-checkbox:checked').length;

            if (checked > 0) {
                sendBtn.disabled = false;
                sendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                sendBtn.disabled = true;
                sendBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        function toggleAll(state) {
            checkboxes.forEach(cb => cb.checked = state);
            updateSendButton();
        }

        // listen to individual checkbox changes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const total = checkboxes.length;
                const checked = document.querySelectorAll('.recipient-checkbox:checked').length;

                // update select-all state
                if (checked === 0) {
                    selectAll.checked = false;
                    selectAll.indeterminate = false;
                } else if (checked === total) {
                    selectAll.checked = true;
                    selectAll.indeterminate = false;
                } else {
                    selectAll.indeterminate = true;
                }

                updateSendButton();
            });
        });
    </script>
</x-app-layout>