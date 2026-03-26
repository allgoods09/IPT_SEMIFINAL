<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SaleObserver
{
    public function created(Sale $sale): void
    {
        Log::create([
            'action' => 'created',
            'entity_type' => 'sale',
            'entity_id' => $sale->id,
            'performed_by' => Auth::id(),
            'description' => "Sale #{$sale->id} created (Product: " . ($sale->product->name ?? 'N/A') . ", Total: ₱" . number_format($sale->total_amount, 2) . ")"
        ]);
    }

    public function updated(Sale $sale): void
    {
        Log::create([
            'action' => 'updated',
            'entity_type' => 'sale',
            'entity_id' => $sale->id,
            'performed_by' => Auth::id(),
            'description' => "Sale #{$sale->id} updated"
        ]);
    }

    public function deleted(Sale $sale): void
    {
        Log::create([
            'action' => 'deleted',
            'entity_type' => 'sale',
            'entity_id' => $sale->id,
            'performed_by' => Auth::id(),
            'description' => "Sale #{$sale->id} deleted"
        ]);
    }
}

