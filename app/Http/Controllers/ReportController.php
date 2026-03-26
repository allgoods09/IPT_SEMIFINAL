<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ReportMailable;
use App\Jobs\SendReportEmailsJob;

class ReportController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('reports.index', compact('users'));
    }

    public function show(string $type, Request $request)
    {
        $month = $request->get('month') ?? now()->format('Y-m');
        $monthStart = Carbon::parse($month)->startOfMonth();
        $monthEnd = Carbon::parse($month)->endOfMonth();

        switch ($type) {
            case 'sales':
                $data = Sale::with('product')
                    ->whereBetween('sale_date', [$monthStart, $monthEnd])
                    ->orderBy('sale_date', 'desc')
                    ->get();
                break;
            case 'products':
                $data = Product::with('category')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('stock_quantity')
                    ->get();
                break;
            case 'categories':
                $data = Category::
                    withCount('products')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('name')
                    ->get();
                break;
            case 'logs':
                $data = Log::whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            default:
                abort(404, 'Report type not found.');
        }

        $users = User::orderBy('name')->get();
        return view("reports.{$type}", compact('data', 'month', 'type', 'users'));
    }

    public function pdf(string $type, Request $request)
    {
        $month = $request->get('month') ?? now()->format('Y-m');
        $monthStart = Carbon::parse($month)->startOfMonth();
        $monthEnd = Carbon::parse($month)->endOfMonth();

        switch ($type) {
            case 'sales':
                $data = Sale::with('product')
                    ->whereBetween('sale_date', [$monthStart, $monthEnd])
                    ->orderBy('sale_date', 'desc')
                    ->get();
                break;
            case 'products':
                $data = Product::with('category')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('stock_quantity')
                    ->get();
                break;
            case 'categories':
                $data = Category::withCount('products')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('name')
                    ->get();
                break;
            case 'logs':
                $data = Log::whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            default:
                abort(404, 'Report type not found.');
        }

        $pdf = Pdf::loadView("reports.{$type}-pdf", compact('data', 'month', 'type'));
        return $pdf->download("{$type}_report_{$month}.pdf");
    }

    public function recipient(string $type, Request $request)
    {
        $month = $request->get('month') ?? now()->format('Y-m');
        $users = User::orderBy('name')->get();

        return view('reports.recipient', compact('type', 'month', 'users'));
    }


    public function email(string $type, Request $request)
    {
        $recipients = $request->input('recipients', []);
        $month = $request->get('month') ?? now()->format('Y-m');
        $monthStart = Carbon::parse($month)->startOfMonth();
        $monthEnd = Carbon::parse($month)->endOfMonth();

        // If "Send to All" clicked
        if ($request->has('send_all')) {
            $recipients = \App\Models\User::pluck('email')->toArray();
        }

        // Same data query as pdf
        switch ($type) {
            case 'sales':
                $data = Sale::with('product')
                    ->whereBetween('sale_date', [$monthStart, $monthEnd])
                    ->orderBy('sale_date', 'desc')
                    ->get();
                break;
            case 'products':
                $data = Product::with('category')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('stock_quantity')
                    ->get();
                break;
            case 'categories':
                $data = Category::withCount('products')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('name')
                    ->get();
                break;
            case 'logs':
                $data = Log::whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            default:
                abort(404);
        }

        $pdf = Pdf::loadView("reports.{$type}-pdf", compact('data', 'month', 'type'));
        $pdfContent = $pdf->output();


        foreach ($recipients as $index => $recipient) {
            SendReportEmailsJob::dispatch($type, $month, $recipient)
            ->delay(now()->addSeconds($index * 20)); // 10s interval
        }


        return back()->with('success', 'Report(s) is/are being sent. Emails will arrive shortly.');
    }

}
