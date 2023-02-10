<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employees";
    protected $primaryKey = "id";

    public function families(){
        return $this->hasMany(Family::class);
    }
    public function education(){
        return $this->hasMany(Education::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
