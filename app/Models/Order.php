<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\order_product;
use App\Models\Customer;
use App\Models\User;


class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customerId','user_id', 'total_amount', 'total_quantity','external_order_id','total_items'];

    public function products()
    {
        return $this->belongstoMany(Product::class);
    }
    public function orderlines()
    {
        return $this->hasMany(order_product::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
