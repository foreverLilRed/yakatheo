<?php

namespace App\Models;

use ArrayAccess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name"
    ];

    public function procurements(){
        return $this->hasMany(Procurement::class);
    }

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%");
        }

        return $query;
    }
}
