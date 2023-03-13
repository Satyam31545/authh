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
    public function user_assign_products()
    {
        return $this->hasMany(UserAssignProduct::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'logs','changer','change_holder');
    }
}
