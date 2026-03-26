<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'quantity', 'price', 'total_amount', 'payment_method', 'sale_date'
    ];

    protected $casts = [
        'sale_date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}