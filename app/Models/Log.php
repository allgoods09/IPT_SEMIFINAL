<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['action', 'entity_type', 'entity_id', 'performed_by', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}