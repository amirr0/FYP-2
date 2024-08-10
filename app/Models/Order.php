<?php

namespace App\Models;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem; // Ensure this line is included

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'assigned_to', 'status', 'total_price','total_progress_percentage'];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function paymentProofs()
    {
        return $this->hasMany(Payment::class);
    }
}
