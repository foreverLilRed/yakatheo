<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Limite extends Model
{
    protected $table = 'limites';

    protected $fillable = ['productor_id','product_id','limit'];

    public function producto(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function productor(){
        return $this->belongsTo(Productor::class,'productor_id');
    }
}
