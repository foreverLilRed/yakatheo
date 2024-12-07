<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    protected $table = 'terrains';
    protected $fillable = [
        'productor_id','place','hr_total','hr_prod'
    ];

    public function productor(){
        return $this->belongsTo(Productor::class);
    }
}
