<?php

namespace App\Listeners;

use App\Events\PaymentCreated;
use App\Models\Credit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class PayCredit
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $payment = $event->payment;
            $credit = $payment->credit;

            if ($credit->remaining_balance < $payment->amount) {
                throw new \Exception('El monto del pago excede el balance restante.');
            }

            $credit->remaining_balance -= $payment->amount;

            if ($credit->remaining_balance == 0) {
                $credit->status = Credit::STATUS_PAID;
            }

            $credit->save();
        });
    }
}
