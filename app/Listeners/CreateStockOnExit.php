<?php

namespace App\Listeners;

use App\Events\SaleCreated;
use App\Models\Stock;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateStockOnExit
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
    public function handle(SaleCreated $event): void
    {
        Stock::create([
            'product_id' => $event->sale->product_id,
            'quantity' => $event->sale->weight,
            'status' => false,
        ]);
    }
}
