<?php

namespace App\Http\Controllers;

use App\Events\SaleCreated;
use App\Models\Sale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Sales/Index', [
            'sales' => Sale::query()
                ->orderBy('created_at', 'desc')
                ->filter(RequestFacade::get('search'))
                ->paginate(25)
                ->withQueryString()
                ->through(fn($sale) => [
                    'id' => $sale->id,
                    'fecha' => $sale->created_at->format('d/m/Y'),
                    "product" => $sale->product,
                    "buyer" => $sale->buyer,
                    "weight" => $sale->weight,
                    "unit_price" => $sale->unit_price,
                    "document_number" => $sale->document_number,
                    "total" => $sale->total(),
                    "documento" => $sale->document_path
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
            'buyer_id' => 'required|exists:buyers,id',
            'weight' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0.01',
            'document_number' => 'required',
        ],[
            'product_id.required' => 'El producto es requerido',
            'product_id.exists' => 'El producto no existe',
            'buyer_id.required' => 'El comprador es requerido',
            'buyer_id.exists' => 'El comprador no existe',
            'weight.required' => 'El peso es requerido',
            'unit_price.required' => 'El precio unitario es requerido',
            'document_number.required' => 'El número de documento es requerido',
            'document_number.string' => 'El número de documento debe ser una cadena de texto',
            'weight.min' => 'El peso debe ser un numero',
            'unit_price.min' => 'El precio unitario debe ser un numero',
        ]); 

        $sale = Sale::create($request->all());
        
        event(new SaleCreated($sale));
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function upload(Request $request, Sale $sale)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:1024', 
        ]);
    
        if ($sale->document_path && Storage::disk('public')->exists($sale->document_path)) {
            Storage::disk('public')->delete($sale->document_path);
        }
    
        $fileName = "{$sale->id}." . $request->file('document')->getClientOriginalExtension();
    
        $request->file('document')->storeAs('sales', $fileName, 'public');
    
    }

}
