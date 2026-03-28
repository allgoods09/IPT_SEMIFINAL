<?php

namespace App\Jobs;

use App\Mail\ReportMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        Mail::to($this->recipient)->queue(
            new ReportMailable(
                ucfirst($this->type) . ' Report - ' . Carbon::parse($this->month)->format('F Y'),
                $this->type,
                $this->month
            )
        );
    }
}