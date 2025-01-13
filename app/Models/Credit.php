<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
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

    public function getLoanDateAttribute($value)
    {
        return $this->formatDate($value);
    }

    public function getDueDateAttribute($value)
    {
        return $this->formatDate($value);
    }

    private function formatDate($value)
    {
        return Carbon::parse($value)->translatedFormat('j \d\e F \d\e\l Y');
    }

}
