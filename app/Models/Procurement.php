<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    protected $fillable = [
        'product_id', 'productor_id', 'weight', 'unit_price'
    ];

    public function productor(){
        return $this->belongsTo(Productor::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function total(){
        return $this->weight * $this->unit_price;
    }

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->whereHas('productor', function ($q) use ($search) {
                $q->where('names', 'like', "%{$search}%");
            });
        }

        return $query;
    }

}
