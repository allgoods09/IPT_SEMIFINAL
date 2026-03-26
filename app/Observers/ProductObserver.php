<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    public function created(Product $product): void
    {
        Log::create([
            'action' => 'created',
            'entity_type' => 'product',
            'entity_id' => $product->id,
            'performed_by' => Auth::id(),
            'description' => "Product '{$product->name}' created"
        ]);
    }

    public function updated(Product $product): void
    {
        $changes = $product->getChanges();
        $desc = "Product '{$product->name}' updated";
        $action = 'updated';

        if (isset($changes['status']) && $product->status === 'inactive') {
            $action = 'deactivated';
            $desc = "Product '{$product->name}' deactivated";
        }

        Log::create([
            'action' => $action,
            'entity_type' => 'product',
            'entity_id' => $product->id,
            'performed_by' => Auth::id(),
            'description' => $desc
        ]);
    }

    public function deleted(Product $product): void
    {
        Log::create([
            'action' => 'deleted',
            'entity_type' => 'product',
            'entity_id' => $product->id,
            'performed_by' => Auth::id(),
            'description' => "Product '{$product->name}' deleted"
        ]);
    }
}

