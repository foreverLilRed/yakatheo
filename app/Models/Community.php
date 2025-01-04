<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    protected $table = 'communities';
    protected $fillable = ['name'];

    public function productors()
    {
        return $this->hasMany(Productor::class);
    }

    public function scopeFilter($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%");
        }
        return $query;
    }
}
