<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'note', 'status'];

    protected static function booted()
    {
        static::updated(function ($orderItem) {
            if ($orderItem->isDirty('status')) {
                event(new \App\Events\OrderItemUpdated($orderItem));
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
