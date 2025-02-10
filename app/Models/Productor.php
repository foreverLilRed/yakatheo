<?php

namespace App\Models;

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

    public function seals()
    {
        return $this->belongsToMany(Seal::class, 'productor_seal');
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
    
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

}
