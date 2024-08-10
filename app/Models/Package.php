<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['service_id', 'name', 'price', 'status'];

    public function items()
    {
        return $this->hasMany(PackageItem::class);
    }

      public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }
}
