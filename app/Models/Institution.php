<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
        'name'
    ];

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function scopeFilter($query, $search)
    {
        return $query->where('name', 'like', '%'.$search.'%');
    }
}
