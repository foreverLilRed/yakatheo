<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    protected $fillable = [
        'procurement_id', 'amount'
    ];

    public function procurement(){
        return $this->belongsTo(Procurement::class);
    }

}
