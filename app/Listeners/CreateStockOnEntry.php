<?php

namespace App\Listeners;

use App\Events\ProcurementEntered;
use App\Models\Stock;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateStockOnEntry
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
    public function handle(ProcurementEntered $event): void
    {
        Stock::create([
            'product_id' => $event->procurement->product_id,
            'quantity' => $event->procurement->weight,
            'status' => true
        ]);
    }
}
