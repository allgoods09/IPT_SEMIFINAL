<x-app-layout>
    <x-slot name="pageTitle">New Sale</x-slot>
    <x-slot name="pageSubtitle">Record a sales transaction</x-slot>

    @if ($errors->any())
        <div class="flash-error mb-5">{{ $errors->first() }}</div>
    @endif

    <div class="max-w-xl mx-auto">
        <div class="card p-8">
            <form method="POST" action="{{ route('sales.store') }}" class="space-y-5" id="saleForm">                @csrf
                <div>
                    <label class="input-label">Product *</label>
                    <select name="product_id" id="productSelect" class="text-input w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500"" onchange="updatePrice()" required>
                        <option value="">— Select Product —</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}" 
                                data-price="{{ $p->selling_price }}" 
                                data-stock="{{ $p->stock_quantity }}"
                                {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} (Stock: {{ $p->stock_quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="priceInfo" class="hidden p-4 rounded-xl" style="background:#f0fdf4; border:1px solid #86efac;">
                    <div class="text-sm font-semibold text-slate-700">Unit Price: <span id="displayPrice" class="text-green-700"></span></div>
                    <div class="text-xs text-slate-500 mt-0.5">Available Stock: <span id="displayStock"></span> units</div>
                </div>

                <div>
                    <label class="input-label">Quantity *</label>
                    <input type="number" name="quantity" id="quantityInput" class="text-input w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500" min="1" placeholder="1" value="{{ old('quantity') }}" oninput="updateTotal()" required>
                </div>

                <div>
                    <label class="input-label">Payment Method *</label>
                    <select name="payment_method" class="text-input w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500" required>
                        <option value="">— Select —</option>
                        @foreach (['Cash','GCash','PayMaya','Credit Card','Debit Card','Bank Transfer'] as $pm)
                            <option value="{{ $pm }}" {{ old('payment_method') == $pm ? 'selected' : '' }}>{{ $pm }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="totalBox" class="hidden p-4 rounded-xl" style="background:#0d1b2a;">
                    <div class="text-xs text-slate-400 uppercase tracking-wide font-semibold mb-1">Total Amount</div>
                    <div class="text-3xl font-bold text-white" id="displayTotal">₱0.00</div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold">Record Sale</button>
                    <a href="{{ route('sales.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updatePrice() {
            const sel = document.getElementById('productSelect');
            const opt = sel.options[sel.selectedIndex];
            const price = parseFloat(opt.dataset.price || 0);
            const stock = parseInt(opt.dataset.stock || 0);
            const info = document.getElementById('priceInfo');
            if (price) {
                document.getElementById('displayPrice').textContent = '₱' + price.toFixed(2);
                document.getElementById('displayStock').textContent = stock;
                info.classList.remove('hidden');
                document.getElementById('quantityInput').max = stock;
            } else {
                info.classList.add('hidden');
            }
            updateTotal();
        }
        function updateTotal() {
            const sel = document.getElementById('productSelect');
            const opt = sel.options[sel.selectedIndex];
            const price = parseFloat(opt.dataset.price || 0);
            const qty = parseInt(document.getElementById('quantityInput').value || 0);
            const box = document.getElementById('totalBox');
            if (price && qty > 0) {
                document.getElementById('displayTotal').textContent = '₱' + (price * qty).toFixed(2).replace(/\\B(?=(\\d{3}))+(?!\\d)/g, ',');
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>

