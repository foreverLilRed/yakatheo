<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    protected $fillable = [
        'product_id',
        'productor_id',
        'weight',
        'unit_price'
    ];

    public function productor()
    {
        return $this->belongsTo(Productor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function total()
    {
        return round($this->weight * $this->unit_price, 2);
    }

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
                ->orWhereHas('productor', function ($q) use ($search) {
                    $q->whereRaw("CONCAT(names, ' ', surnames) LIKE ?", ["%{$search}%"])
                        ->orWhere('dni', 'like', "%{$search}%");
                });
        }

        return $query;
    }
}
