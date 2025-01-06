<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id', 'quantity', 'status' // true (1) para entrada y false (0) para salida
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
