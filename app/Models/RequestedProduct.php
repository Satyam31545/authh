<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestedProduct extends Model
{
    use HasFactory;
    public $timestamps =false;
    protected $fillable = [
        'product_id','quantity','product_request_id'
   ];
   public function product(): BelongsTo
   {
       return $this->belongsTo(Product::class);
   }
   public function productRequest(): BelongsTo
   {
       return $this->belongsTo(ProductRequest::class);
   }
}
