<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name' => 'required'
        ]);

        Buyer::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buyer $buyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buyer $buyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buyer $buyer)
    {
        //
    }

    public function fetchQuery(Request $request){
        $buyers = Buyer::query()
            ->orderBy('name')
            ->filter($request->search)
            ->paginate(15)
            ->withQueryString()
            ->through(function ($productor) {
                return [
                    'id' => $productor->id,
                    'nombres' => $productor->name,
                ];
            });

        return response()->json($buyers);
    }

    public function fetch()
    {
        $buyers = Buyer::all();
        return response()->json($buyers);
    }
}
