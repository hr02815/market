<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class order_product extends Model
{
    protected $table = 'order_product';
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity'];
    
    public function orders()
    {
        return $this->belongsto(Order::class);
    }

}
