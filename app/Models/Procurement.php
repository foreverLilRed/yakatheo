<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    protected $fillable = [
        'product_id', 'productor_id', 'weight', 'unit_price', 'humidity', 'impurity',
        'recovery', 'credit', 'cash' //campos opcionales
    ];

    public function productor(){
        return $this->belongsTo(Productor::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopeFilter($query, $search){
        if ($search) {
            return $query->where('product_id', 'like', "%{$search}%");
        }

        return $query;
    }

    public function credit(){
        return $this->hasOne(Credit::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function recovery(){
        return $this->hasOne(Recovery::class);
    }
}
