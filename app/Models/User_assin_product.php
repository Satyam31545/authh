<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User_assin_product extends Model
{
    use HasFactory;
    protected $table = "user_assin_products";
    protected $primaryKey = "id";
    public $timestamps =false;
    protected $fillable = [
        'user_id', 'product_id',
   ];
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
