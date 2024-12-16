<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items(){
        return $this->hasMany(OrderItems::class);
    }

    public function payment(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
