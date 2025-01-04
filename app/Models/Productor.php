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
        "community_id"
    ];

    public function seals()
    {
        return $this->belongsToMany(Seal::class, 'productor_seal');
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
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

    public function balance()
    {
        return $this->credits()->sum('balance');
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function discount($amount)
    {
        if ($this->balance() < $amount) {
            throw new \Exception("El monto a descontar excede el balance disponible del productor.");
        }

        $credits = $this->credits()->orderBy('created_at')->get();

        foreach ($credits as $credit) {
            if ($amount <= 0) {
                break;
            }

            $currentBalance = $credit->balance;

            if ($currentBalance > 0) {
                if ($amount >= $currentBalance) {
                    $amount -= $currentBalance;
                    $credit->balance = 0;
                } else {
                    $credit->balance -= $amount;
                    $amount = 0;
                }

                $credit->save();
            }
        }

        return true; 
    }
}
