<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','name', 'salary','desigination', 'dob','address'
   ];
    public function families(){
        return $this->hasMany(Family::class);
    }
    public function education(){
        return $this->hasMany(Education::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function UserAssignProducts()
    {
        return $this->hasMany(UserAssinProduct::class);
    }
    public function products()
    {
       return $this->BelongsToMany(Product::class,'user_assin_products')->withPivot('quantity');
    }
}
