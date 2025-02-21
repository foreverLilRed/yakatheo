<?php

namespace App\Models;

use App\Exceptions\LimiteDeProduccion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{
    use HasFactory;
    protected $fillable = [
        "names",
        "surnames",
        "dni",
        "birthday",
        "community_id",
        "socio"
    ];

    protected $casts = [
        'socio' => 'boolean', // Asegura que siempre sea booleano
    ];

    public function seals()
    {
        return $this->belongsToMany(Seal::class, 'productor_seal');
    }

    public function normas()
    {
        return $this->belongsToMany(Norma::class, 'productor_norma', 'productor_id', 'norma_id');
    }


    public function condiciones(){
        return $this->belongsToMany(Condicion::class,'productor_condicion','productor_id', 'condicion_id');
    }


    public function terrains()
    {
        return $this->hasMany(Terrain::class);
    }

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->where('names', 'like', "%{$search}%")
                ->orWhere('surnames', 'like', "%{$search}%")
                ->orWhere('dni', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        }

        return $query;
    }

    public function procurements()
    {
        return $this->hasMany(Procurement::class);
    }

    public function acopiosEnRango($inicio = null, $fin = null) {
        $inicio = $inicio ?? Carbon::now()->startOfMonth();
        $fin = $fin ?? Carbon::now()->endOfMonth();
        
        return $this->procurements()
            ->whereBetween('created_at', [$inicio, $fin])
            ->get();
    }
    
    
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function limites(){
        return $this->hasMany(Limite::class);
    }

    public function produccionAnual($producto){
        return $this->procurements()
                ->where('product_id',$producto)
                    ->whereYear('created_at', now()->year)
                        ->sum('weight'); 
    }

    public function limite($product_id, $quantity)
    {
        $producido_anho_actual = $this->produccionAnual($product_id);

        $limite = $this->limites()->where('product_id', $product_id)->first();

        if ($limite && ($producido_anho_actual + $quantity) > $limite->limit) {
            throw new LimiteDeProduccion();
        }

        return true;
    }

    public function detallesProduccion()
    {
        return $this->limites()->with('producto')->get()->map(function ($limite) {
            return [
                'producto' => $limite->producto?->name ?? 'Desconocido', // Previene errores si producto es null
                'limite' => (float) $limite->limit,
                'actual' => (float) $this->produccionAnual($limite->producto?->id ?? 0) // Evita error si producto es null
            ];
        });
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($productor) {
            static::created(function ($productor) {
                $productos = Product::all(); 

                foreach ($productos as $producto) {
                    Limite::create([
                        'productor_id' => $productor->id,
                        'product_id' => $producto->id,
                        'limit' => 1000, 
                    ]);
                }
            });
        });
    }

}
