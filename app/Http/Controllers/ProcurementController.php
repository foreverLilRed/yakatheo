<?php

namespace App\Http\Controllers;

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
            'productor_id' => 'required|exists:productors,id',
            'weight' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'humidity' => 'required|numeric',
            'impurity' => 'required|numeric',
            'recovery' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'cash' => 'nullable|numeric'
        ]);

        $procurement = Procurement::create($request->all());

        if ($request->filled('cash')) {
            $procurement->payment()->create([
                'amount' => $request->input('cash'),
            ]);
        }

        if ($request->filled('credit')) {
            $procurement->credit()->create([
                'productor_id' => $request->input('productor_id'),
                'amount' => $request->input('credit'),
                'balance' => $request->input('credit'),
            ]);
        }

        if ($request->filled('recovery')) {
            $recoveryAmount = $request->input('recovery');

            try {
                $procurement->productor->discount($recoveryAmount);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'No se puede realizar el descuento: ' . $e->getMessage(),
                ], 400);
            }
        }
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
