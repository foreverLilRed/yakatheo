<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        "product_id",
        "buyer_id",
        "weight",
        "unit_price",
        "document_number",
        "document_path"
    ];

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->whereHas('buyer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function total()
    {
        return $this->weight * $this->unit_price;
    }

    protected static function booted()
    {
        static::creating(function ($sale) {
            $product = Product::find($sale->product_id);
        
            if ($sale->weight > $product->totalStock()) {
                return false;
            }
            return true;
        });
        
    }
}
