<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'changer_id', 'change_holder_id', 'product_id', 'quantity', 'operation',
    ];

    public function changer(): BelongsTo
    {
        return $this->belongsTo(Employee::class);

    }
    public function change_holder(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
