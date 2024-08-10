<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Order;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

{

    use HasApiTokens, SoftDeletes, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'status',
        'profile_picture',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    public function client_orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
