<?php

namespace App\Models;

use App\Exceptions\LimiteDeProduccion;
use ArrayAccess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name"
    ];

    public function procurements()
    {
        return $this->hasMany(Procurement::class);
    }

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%");
        }

        return $query;
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function totalStock()
    {
        return $this->stocks->where('status', 1)->sum('quantity') - $this->stocks->where('status', 0)->sum('quantity');
    }

    public function earnings($from = null)
    {
        $query = $this->sales();

        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        return $query->get()->map(function ($sale) {
            return $sale->total();
        })->sum();
    }

    public function precio_promedio()
    {
        return $this->procurements()->avg('unit_price') ?? 0;
    }

    public function limites()
    {
        return $this->hasMany(Limite::class);
    }
    
}
