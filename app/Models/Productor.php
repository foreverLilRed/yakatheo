<?php

namespace App\Models;

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


}
