<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Procurements/Index', [
            'procurements' => Procurement::query()
                ->orderBy('weight')
                ->filter(RequestFacade::get('search'))
                ->paginate(25)
                ->withQueryString()
                ->through(fn($procurement) => [
                    'id' => $procurement->id,
                    'producto' => $procurement->product,
                    'total_price' => $procurement->total_price,
                    'humidity' => $procurement->humidity,
                    'impurity' => $procurement->impurity,
                    'recovery' => $procurement->recovery,
                    'credit' => $procurement->credit,
                    'cash' => $procurement->cash
                ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'weight' => 'required|numeric',
            'total_price' => 'required|numeric',
            'humidity' => 'required|numeric',
            'impurity' => 'required|numeric',
            'recovery' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'cash' => 'nullable|numeric'
        ]);

        Procurement::create([
            'product_id' => $request->product_id,
            'weight' => $request->weight,
            'total_price' => $request->total_price,
            'humidity' => $request->humidity,
            'impurity' => $request->impurity,
            'recovery' => $request->recovery,
            'credit' => $request->credit,
            'cash' => $request->cash
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Procurement $procurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procurement $procurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procurement $procurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procurement $procurement)
    {
        //
    }
}
