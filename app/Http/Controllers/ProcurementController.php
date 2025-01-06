<?php

namespace App\Http\Controllers;

use App\Events\ProcurementEntered;
use App\Models\Procurement;
use App\Http\Controllers\Controller;
use App\Models\Productor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->with(['productor.community', 'product'])
                ->orderBy('weight')
                ->filter(RequestFacade::get('search'))
                ->paginate(25)
                ->withQueryString()
                ->through(fn($procurement) => [
                    'id' => $procurement->id,
                    'weight' => $procurement->weight,
                    'unit_price' => $procurement->unit_price,
                    'product' => $procurement->product,
                    'productor' => $procurement->productor,
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
            'productor_id' => 'required|exists:productors,id',
            'weight' => 'required|numeric',
            'unit_price' => 'required|numeric'
        ]);

        $procurement = Procurement::create($request->all());

        event(new ProcurementEntered($procurement));
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
