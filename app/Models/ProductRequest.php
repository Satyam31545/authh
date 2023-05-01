<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id', 'remark', 'status', 'due_date', 'request_id',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function requestedProducts()
    {
        return $this->hasMany(RequestedProduct::class);
    }
}
