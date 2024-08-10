<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{

    protected $fillable = ['order_id', 'transaction_id', 'amount', 'payment_proof'];

    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
