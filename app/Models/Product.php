<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Kind;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price', 'detail', 'image'
    ];
    
    public function orders() {
        return $this->belongsToMany(Order::class);
    }

    public function kindproducts() {
        return $this->belongsToMany(Kind::class)->withTimestamps();
    }
}
