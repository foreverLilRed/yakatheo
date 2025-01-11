<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'institution_id', //form
        'credit', //form
        'interest_rate', //form
        'total_amount', //form
        'remaining_balance',
        'loan_date', //form
        'due_date', //form
        'status',
        'currency',
        'purpose', //form
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_PAID = 'paid';
    public const STATUS_OVERDUE = 'overdue';

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function scopeFilter($query, $search){
        if ($search) {
            return $query->whereHas('institution', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    protected static function boot(){
        parent::boot();
        static::creating(function ($credit) {
            $credit->remaining_balance = $credit->total_amount;
        });
    }

}
