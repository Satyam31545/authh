<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Product extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = [
        'name', 'prize','quantity','description','tax'
   ];
    public function UserAssignProducts()
    {
        return $this->hasMany(UserAssinProduct::class);
    }
    public function employees()
    {
       return $this->BelongsToMany(Employee::class,'user_assin_products','product_id','employee_id');
    }

}
