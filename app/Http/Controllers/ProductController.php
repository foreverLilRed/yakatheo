<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;
use App\Models\Productor;
use App\Models\Seal;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Products/Index',[
            'products' => Product::query()
                ->orderBy('name')
                ->filter(RequestFacade::get('search'))
                ->paginate(25)
                ->withQueryString()
                ->through(fn($product) => [
                    'id' => $product->id,
                    'nombres' => $product->name
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
        $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'El campo nombre es obligatorio.',
            ]
        );
        Product::create([
            'name' => $request->name
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function fetch(){
        return response()->json(Product::all());
    }

    public function adjustement(Request $request) {
        $weight = $request->weight;
        $i = $request->i;
        $penalize = 0;
    
        if ($i >= 8) {
            $penalize = floor($weight / 50);
        }
    
        $adjustedWeight = $weight - $penalize;
    
        return response()->json(['adjustedWeight' => $request]);
    }
    
}
