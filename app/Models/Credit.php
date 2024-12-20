<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'productor_id','procurement_id', 'amount','balance'
    ];
}
