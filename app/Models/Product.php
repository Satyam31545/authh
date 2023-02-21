<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'prize','quantity','description','tax'
   ];
    public function user_assign_products()
    {
        return $this->hasMany(User_assin_product::class,'id','product_id');
    }
}
