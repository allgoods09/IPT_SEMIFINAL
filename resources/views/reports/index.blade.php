<x-app-layout>
    <x-slot name="pageTitle">Report Generation</x-slot>
    <x-slot name="pageSubtitle">Generate business reports by type and month</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="card p-10">

            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-4" style="background:rgba(22,179,110,0.1);">
                    <svg class="w-7 h-7" style="stroke:#16b36e;" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-1">Report Generation</h2>
                <p class="text-slate-400 text-sm">Select a report type and month to generate</p>
            </div>

            <div class="space-y-6">

                {{-- Report Type --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">Report Type</label>
                    <div class="relative" id="selectWrap">
                        <button type="button" id="selectBtn" onclick="toggleDropdown()"
                            class="w-full flex items-center gap-3 px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-sm font-medium text-slate-700 transition-all duration-150">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(22,179,110,0.1);">
                                <svg class="w-4 h-4" style="stroke:#16b36e;" fill="none" viewBox="0 0 24 24" id="selBtnIcon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                                </svg>
                            </div>
                            <span class="flex-1 text-left" id="selBtnText">Sales</span>
                            <svg id="selChevron" class="w-4 h-4 transition-transform duration-200" style="stroke:#94a3b8;" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="dropdown" class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white border-2 border-slate-200 rounded-xl overflow-hidden z-50 shadow-lg">
                            @php
                            $options = [
                                ['value' => 'sales',      'label' => 'Sales',      'desc' => 'Revenue & transactions',  'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
                                ['value' => 'products',   'label' => 'Products',   'desc' => 'Inventory & stock levels', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                                ['value' => 'categories', 'label' => 'Categories', 'desc' => 'Product groupings',        'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                                ['value' => 'logs',       'label' => 'Logs',       'desc' => 'Activity & audit trail',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                            ];
                            @endphp
                            @foreach ($options as $opt)
                            <div class="rf-opt flex items-center gap-3 px-4 py-3 cursor-pointer transition-colors duration-100 {{ $opt['value'] === 'sales' ? 'selected' : '' }}"
                                 data-value="{{ $opt['value'] }}"
                                 data-icon="{{ $opt['icon'] }}"
                                 data-label="{{ $opt['label'] }}"
                                 onclick="selectOption(this)"
                                 style="{{ $opt['value'] === 'sales' ? 'background:rgba(22,179,110,0.07);' : '' }}">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#f1f5f9;">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" style="stroke:#94a3b8;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $opt['icon'] }}"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold {{ $opt['value'] === 'sales' ? '' : 'text-slate-700' }}"
                                         style="{{ $opt['value'] === 'sales' ? 'color:#16b36e;' : '' }}">{{ $opt['label'] }}</div>
                                    <div class="text-xs text-slate-400">{{ $opt['desc'] }}</div>
                                </div>
                                <svg class="w-4 h-4 rf-check {{ $opt['value'] === 'sales' ? '' : 'opacity-0' }}" style="stroke:#16b36e;" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" id="typeInput" value="{{ request('type', 'sales') }}">
                </div>

                {{-- Month Picker --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">Month</label>
                    <div class="border-2 border-slate-200 rounded-xl overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-2.5 bg-slate-50 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="changeYear(-1)"
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center transition-all hover:border-green-400 hover:bg-green-50">
                                    <svg class="w-3.5 h-3.5" style="stroke:#94a3b8;" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <span class="text-sm font-semibold text-slate-700 w-12 text-center" id="yearLabel"></span>
                                <button type="button" onclick="changeYear(1)"
                                    class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center transition-all hover:border-green-400 hover:bg-green-50">
                                    <svg class="w-3.5 h-3.5" style="stroke:#94a3b8;" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                            <span class="text-sm font-semibold" style="color:#16b36e;" id="selectedMonthDisplay"></span>
                        </div>
                        <div class="grid grid-cols-4" id="monthGrid"></div>
                    </div>
                    {{-- Single source of truth — JS reads this on init, updates it on every pick --}}
                    <input type="hidden" id="monthInput" value="{{ request('month', now()->format('Y-m')) }}">
                </div>

                <button type="button" onclick="generateReport()"
                    class="w-full btn-primary px-6 py-3.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Generate Report
                </button>

            </div>
        </div>
    </div>

    <style>
        .rf-opt:hover { background: #f8fafc; }
        .rf-opt.selected { background: rgba(22,179,110,0.07); }
        .month-cell {
            padding: 10px 4px; text-align: center; font-size: 13px; font-weight: 500;
            color: #64748b; cursor: pointer; transition: all 0.1s;
            border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9;
        }
        .month-cell:nth-child(4n)  { border-right: none; }
        .month-cell:nth-child(n+9) { border-bottom: none; }
        .month-cell:hover          { background: #f8fafc; color: #1e293b; }
        .month-cell.active         { background: #16b36e !important; color: #fff !important; font-weight: 600; }
        .month-cell.is-now         { color: #16b36e; font-weight: 600; }
        .month-cell.active.is-now  { color: #fff; }
        #selectBtn.open            { border-color: #16b36e !important; box-shadow: 0 0 0 3px rgba(22,179,110,0.12); }
    </style>

    <script>
        const MONTHS  = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const jsNow   = new Date();

        // Read server-rendered value ONCE — JS owns #monthInput from here on.
        // renderGrid() NEVER writes to #monthInput; only setMonth() does.
        const initVal    = document.getElementById('monthInput').value;
        const [iy, im]   = initVal.split('-').map(Number);
        let selYear  = iy;
        let selMonth = im - 1; // convert to 0-indexed

        function setMonth(year, month) {
            selYear  = year;
            selMonth = month;
            // Persist immediately so generateReport() always has the latest value
            document.getElementById('monthInput').value =
                `${selYear}-${String(selMonth + 1).padStart(2, '0')}`;
            renderGrid();
        }

        function renderGrid() {
            const grid = document.getElementById('monthGrid');
            grid.innerHTML = '';
            MONTHS.forEach((m, i) => {
                const cell     = document.createElement('div');
                const isActive = (i === selMonth);
                const isNow    = (i === jsNow.getMonth() && selYear === jsNow.getFullYear());
                cell.className = 'month-cell'
                    + (isActive ? ' active'  : '')
                    + (isNow   ? ' is-now'   : '');
                cell.textContent = m;
                cell.onclick = () => setMonth(selYear, i);
                grid.appendChild(cell);
            });
            document.getElementById('yearLabel').textContent = selYear;
            document.getElementById('selectedMonthDisplay').textContent =
                `${MONTHS[selMonth]} ${selYear}`;
        }

        function changeYear(d) { setMonth(selYear + d, selMonth); }

        // Dropdown
        function toggleDropdown() {
            const dd   = document.getElementById('dropdown');
            const btn  = document.getElementById('selectBtn');
            const ch   = document.getElementById('selChevron');
            const open = !dd.classList.contains('hidden');
            dd.classList.toggle('hidden', open);
            btn.classList.toggle('open', !open);
            ch.style.transform = open ? '' : 'rotate(180deg)';
        }

        function selectOption(el) {
            document.querySelectorAll('.rf-opt').forEach(o => {
                o.classList.remove('selected');
                o.style.background = '';
                o.querySelector('.rf-check').classList.add('opacity-0');
                o.querySelector('div > div:first-child').style.color = '';
            });
            el.classList.add('selected');
            el.style.background = 'rgba(22,179,110,0.07)';
            el.querySelector('.rf-check').classList.remove('opacity-0');
            el.querySelector('div > div:first-child').style.color = '#16b36e';
            document.getElementById('typeInput').value = el.dataset.value;
            document.getElementById('selBtnText').textContent = el.dataset.label;
            document.getElementById('selBtnIcon').innerHTML =
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${el.dataset.icon}"/>`;
            document.getElementById('dropdown').classList.add('hidden');
            document.getElementById('selectBtn').classList.remove('open');
            document.getElementById('selChevron').style.transform = '';
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('#selectWrap')) {
                document.getElementById('dropdown').classList.add('hidden');
                document.getElementById('selectBtn').classList.remove('open');
                document.getElementById('selChevron').style.transform = '';
            }
        });

        function generateReport() {
            const type  = document.getElementById('typeInput').value;
            const month = document.getElementById('monthInput').value; // always current
            window.location.href = `/reports/${type}?month=${month}`;
        }

        // Restore type from URL on back-navigation
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('type')) {
            const opt = document.querySelector(`.rf-opt[data-value="${urlParams.get('type')}"]`);
            if (opt) selectOption(opt);
        }

        renderGrid();
    </script>

</x-app-layout>