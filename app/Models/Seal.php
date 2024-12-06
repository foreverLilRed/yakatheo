<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description'
    ];

    public function productors()
    {
        return $this->belongsToMany(Productor::class, 'productor_seal');
    }
}
