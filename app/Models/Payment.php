<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'credit_id', 'amount'
    ];

    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $credit = Credit::find($payment->credit_id);

            if ($payment->amount <= 0) {
                throw new \Exception('El monto del pago debe ser positivo.');
            }

            if ($payment->amount > $credit->remaining_balance) {
                throw new \Exception('El monto del pago no puede exceder el balance restante.');
            }
        });
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('j \d\e F \d\e\l Y');
    }

}
