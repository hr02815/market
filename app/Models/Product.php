<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'cost_price','selling_price','tax'];

    public function orders()
    {
        return $this->belongstoMany(Order::class);
    }

    public function orderlines()
    {
        return $this->hasMany(order_product::class, 'product_id');
    }
}

