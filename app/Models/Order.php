<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    // relationships
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // attributes
    public function getAdminRevenueAttribute()
    {
        return $this->orderItems->sum(function (OrderItem $orderItem) {
            return $orderItem->admin_revenue;
        });
    }

    public function getAmbassadorRevenueAttribute()
    {
        return $this->orderItems->sum( fn( OrderItem $orderItem) => $orderItem->customer_revenue);
    }
}
