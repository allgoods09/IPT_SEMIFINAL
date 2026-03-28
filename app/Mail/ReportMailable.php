<?php

namespace App\Mail;

use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ReportMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $type;
    public $month;

    public function __construct($subject, $type, $month)
    {
        $this->subject = $subject;
        $this->type = $type;
        $this->month = $month;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * 🔥 CENTRALIZED DATA FETCH (VERY IMPORTANT)
     */
    private function getData()
    {
        $monthStart = Carbon::parse($this->month)->startOfMonth();
        $monthEnd = Carbon::parse($this->month)->endOfMonth();

        return match ($this->type) {
            'sales' => Sale::with('product')
                ->whereBetween('sale_date', [$monthStart, $monthEnd])
                ->orderBy('sale_date', 'desc')
                ->get(),

            'products' => Product::with('category')
                ->where('status', 'active')
                ->orderBy('stock_quantity')
                ->get(),

            'categories' => Category::withCount('products')
                ->orderBy('name')
                ->get(),

            'logs' => Log::whereBetween('created_at', [$monthStart, $monthEnd])
                ->orderBy('created_at', 'desc')
                ->get(),

            default => collect(),
        };
    }

    public function content(): Content
    {
        $data = $this->getData();

        return new Content(
            view: "emails.{$this->type}",
            with: [
                'data' => $data,
                'month' => $this->month,
                'type' => $this->type,
            ],
        );
    }

    public function attachments(): array
    {
        $data = $this->getData();

        $pdf = Pdf::loadView("reports.{$this->type}-pdf", [
            'data' => $data,
            'month' => $this->month,
            'type' => $this->type,
        ]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                $this->type . '_report.pdf'
            )->withMime('application/pdf'),
        ];
    }
}