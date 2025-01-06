<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
        "name"
    ];

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function scopeFilter($query, $search){

        if ($search) {
            return $query->where('name', 'like', "%{$search}%");
        }

        return $query;
    }
}
