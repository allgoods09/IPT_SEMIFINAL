<x-app-layout>
    <x-slot name="pageTitle">Edit Sale</x-slot>
    <x-slot name="pageSubtitle">Modify transaction #{{ $sale->id }}</x-slot>

    @if ($errors->any())
        <div class="flash-error mb-5">{{ $errors->first() }}</div>
    @endif

    <div class="max-w-xl mx-auto">
        <div class="card p-8">

            {{-- Sale info banner --}}
            <div class="mb-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Editing Sale</div>
                <div class="font-bold text-slate-800 text-lg">{{ $sale->product->name }}</div>
                <div class="text-sm text-slate-500 mt-0.5">
                    Unit price: <strong>₱{{ number_format($sale->price, 2) }}</strong> &nbsp;·&nbsp;
                    Max qty available: <strong>{{ $sale->product->stock_quantity + $sale->quantity }}</strong>
                </div>
            </div>

            <form method="POST" action="{{ route('sales.update', $sale) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="input-label">Quantity *</label>
                    <input type="number" name="quantity" min="1" max="{{ $sale->product->stock_quantity + $sale->quantity }}"
                        value="{{ old('quantity', $sale->quantity) }}" id="qtyInput" oninput="updateTotal()" class="text-input w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500" required>
                    <p class="text-xs text-slate-400 mt-1">Originally: {{ $sale->quantity }} units</p>
                </div>

                <div>
                    <label class="input-label">Payment Method *</label>
                    <select name="payment_method" class="text-input w-full px-4 py-3 text-base rounded-md border border-slate-300 focus:ring focus:ring-indigo-200 focus:border-indigo-500" required>
                        @foreach (['Cash','GCash','PayMaya','Credit Card','Debit Card','Bank Transfer'] as $pm)
                            <option value="{{ $pm }}" {{ old('payment_method', $sale->payment_method) == $pm ? 'selected' : '' }}>{{ $pm }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Live total preview --}}
                <div class="p-4 rounded-xl bg-slate-900">
                    <div class="text-xs text-slate-400 uppercase tracking-wide font-semibold mb-1">New Total</div>
                    <div class="text-3xl font-bold text-white" id="totalDisplay">
                        ₱{{ number_format($sale->price * $sale->quantity, 2) }}
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary px-6 py-2.5 rounded-xl text-sm font-semibold">Update Sale</button>
                    <a href="{{ route('sales.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const unitPrice = {{ $sale->price }};
        function updateTotal() {
            const qty = parseInt(document.getElementById('qtyInput').value) || 0;
            document.getElementById('totalDisplay').textContent = '₱' + (unitPrice * qty).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    </script>
</x-app-layout>

