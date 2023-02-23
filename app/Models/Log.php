<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = "logs";
    protected $primaryKey = "id";

    protected $fillable = [
        'changer', 'change_holder','product_id','quantity','operation'
   ];

   public function users()
   {
       return $this->hasMany(User::class,'id', 'changer');

   }
   public function myusers()
   {
       return $this->hasMany(User::class,'id', 'change_holder');
   }
   public function products()
   {
       return $this->hasMany(Product::class, 'id','product_id');
   }

}
