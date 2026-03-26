<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalProducts   = DB::table('products')->where('status', 'active')->count();
    $totalCategories = DB::table('categories')->where('status', 'active')->count();
    $totalSales      = DB::table('sales')->count();
    $totalRevenue    = DB::table('sales')->sum('total_amount') ?? 0;
    $lowStock        = DB::table('products')
                         ->whereColumn('stock_quantity', '<=', 'reorder_level')
                         ->where('status', 'active')
                         ->count();
 
    $recentSales = DB::table('sales as s')
        ->join('products as p', 's.product_id', '=', 'p.id')
        ->select('s.*', 'p.name as product_name')
        ->orderBy('s.sale_date', 'desc')
        ->limit(8)
        ->get();
 
    $lowStockProducts = DB::table('products as p')
        ->leftJoin('categories as c', 'p.category_id', '=', 'c.id')
        ->select('p.*', 'c.name as category_name')
        ->whereColumn('p.stock_quantity', '<=', 'p.reorder_level')
        ->where('p.status', 'active')
        ->limit(5)
        ->get();
 
    return view('dashboard', compact(
        'totalProducts', 'totalCategories', 'totalSales',
        'totalRevenue', 'lowStock', 'recentSales', 'lowStockProducts'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('logs', LogController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{type}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{type}/recipient', [ReportController::class, 'recipient'])->name('reports.recipient');
    Route::get('/reports/{type}/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::post('/reports/{type}/mail', [ReportController::class, 'email'])->name('reports.mail');
});

require __DIR__.'/auth.php';
