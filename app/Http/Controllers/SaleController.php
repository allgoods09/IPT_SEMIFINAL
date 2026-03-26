<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $sales = Sale::with('product')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('sale_date', 'desc')
            ->get();

        $totalRevenue = Sale::sum('total_amount') ?? 0;
        $totalSales = Sale::count();
        $avgSaleValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        $msg = session('msg');

        return view('sales.index', compact('sales', 'search', 'totalRevenue', 'totalSales', 'avgSaleValue', 'msg'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1',
            'payment_method'=>'required|string|max:50',
            'sale_date'=>'nullable|date',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->status !== 'active') {
            return back()->withErrors(['product_id' => 'Product must be active.']);
        }

        if ($product->stock_quantity < $data['quantity']) {
            return back()->withErrors([
                'quantity' => 'Insufficient stock. Available: ' . $product->stock_quantity
            ]);
        }

        // ✅ compute values here
        $data['price'] = $product->selling_price;
        $data['total_amount'] = $product->selling_price * $data['quantity'];
        $data['sale_date'] = $data['sale_date'] ?? now();

        Sale::create($data);

        $product->decrement('stock_quantity', $data['quantity']);

        return redirect()->route('sales.index')->with('msg', 'saved');
    }

    public function show(Sale $sale)
    {
        $sale->load('product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $sale->load('product');
        $products = Product::where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $oldQty = $sale->quantity;
        $product = $sale->product;
        if (!$product || $product->status !== 'active') {
            return back()->withErrors(['product_id' => 'Product must be active.']);
        }

        $data = $request->validate([
            'quantity'=>'required|integer|min:1',
            'payment_method'=>'required|string|max:50',
        ]);

        $availableStock = $product->stock_quantity + $oldQty;
        if ($data['quantity'] > $availableStock) {
            return back()->withErrors(['quantity' => 'Not enough stock. Max available: ' . $availableStock . ' units.']);
        }

        $stockDiff = $oldQty - $data['quantity'];
        $sale->update(array_merge($data, ['total_amount' => $data['quantity'] * $sale->price]));
        $product->increment('stock_quantity', $stockDiff);

        return redirect()->route('sales.index')->with('msg', 'updated');
    }

    public function destroy(Sale $sale)
    {
        $sale->product->increment('stock_quantity', $sale->quantity);
        $sale->delete();

        return redirect()->route('sales.index')->with('msg', 'deleted');
    }
}

