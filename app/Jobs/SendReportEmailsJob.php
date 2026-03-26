<?php

namespace App\Jobs;

use App\Mail\ReportMailable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\Sale;

class SendReportEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $month;
    protected $recipient;

    public function __construct($type, $month, $recipient)
    {
        $this->type = $type;
        $this->month = $month;
        $this->recipient = $recipient;
    }

    public function handle(): void
    {
        $monthStart = Carbon::parse($this->month)->startOfMonth();
        $monthEnd = Carbon::parse($this->month)->endOfMonth();

        // Same logic as your controller
        switch ($this->type) {
            case 'sales':
                $data = Sale::with('product')
                    ->whereBetween('sale_date', [$monthStart, $monthEnd])
                    ->orderBy('sale_date', 'desc')
                    ->get();
                break;

            case 'products':
                $data = Product::with('category')
                    ->where('status', 'active')
                    ->orderBy('stock_quantity')
                    ->get();
                break;

            case 'categories':
                $data = Category::withCount('products')
                    ->orderBy('name')
                    ->get();
                break;

            case 'logs':
                $data = Log::whereBetween('created_at', [$monthStart, $monthEnd])
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;

            default:
                return;
        }

        $pdf = Pdf::loadView("reports.{$this->type}-pdf", [
            'data' => $data,
            'month' => $this->month,
            'type' => $this->type
        ]);

        $pdfContent = $pdf->output();

        Mail::to($this->recipient)->send(
            new ReportMailable(
                $pdfContent,
                ucfirst($this->type) . ' Report - ' . Carbon::parse($this->month)->format('F Y'),
                $this->type,
                $data,
                $this->month
            )
        );
    }
}