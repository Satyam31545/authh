<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAssinProduct extends Model
{
    use HasFactory;
    public $timestamps =false;
    protected $fillable = [
        'user_id', 'product_id','quantity'
   ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function Employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
