<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_name', 'user_email','service_id', 'review', 'rating'];


    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
