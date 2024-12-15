<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    protected $fillable = [
        'product_id', 'productor_id', 'weight', 'unit_price', 'humidity', 'impurity',
        'recovery', 'credit', 'cash' //campos opcionales
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopeFilter($query, $search){
        if ($search) {
            return $query->where('product_id', 'like', "%{$search}%");
        }

        return $query;
    }
}
