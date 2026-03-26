<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    public function created(Category $category): void
    {
        Log::create([
            'action' => 'created',
            'entity_type' => 'category',
            'entity_id' => $category->id,
            'performed_by' => Auth::id(),
            'description' => "Category '{$category->name}' created"
        ]);
    }

    public function updated(Category $category): void
{
        $changes = $category->getChanges();
        $desc = "Category '{$category->name}' updated";
        $action = 'updated';

        if (isset($changes['status']) && $category->status === 'inactive') {
            $action = 'deactivated';
            $desc = "Category '{$category->name}' deactivated";
        }

        Log::create([
            'action' => $action,
            'entity_type' => 'category',
            'entity_id' => $category->id,
            'performed_by' => Auth::id(),
            'description' => $desc
        ]);
    }

    public function deleted(Category $category): void
    {
        Log::create([
            'action' => 'deleted',
            'entity_type' => 'category',
            'entity_id' => $category->id,
            'performed_by' => Auth::id(),
            'description' => "Category '{$category->name}' deleted"
        ]);
    }
}

