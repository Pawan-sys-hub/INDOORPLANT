<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'full_name', 'email', 'phone', 'address',
        'subtotal', 'discount_amount', 'total_amount',
        'order_status', 'payment_status', 'payment_method',
        'esewa_transaction_uuid', 'esewa_ref_id', 'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->order_status) {
            'pending'   => 'warning',
            'processing'=> 'info',
            'shipped'   => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'paid'   => 'success',
            'unpaid' => 'warning',
            'failed' => 'danger',
            default  => 'secondary',
        };
    }
}
