<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Http\Controllers\Controller;
use App\Models\Productor;
use Illuminate\Http\Request;

class TerrainController extends Controller
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
            'productor_id' => 'required|exists:productors,id', // Verifica que el ID exista en la tabla productors
            'hr_total' => 'required|numeric', // Verifica que sea un número (decimal o entero)
            'hr_prod' => 'required|numeric|lte:hr_total', // Verifica que sea un número y que hr_prod sea <= hr_total
            'place' => 'required|string|max:1000', // Verifica que sea una cadena de texto larga
        ], [
            'productor_id.required' => 'El campo productor es obligatorio.',
            'productor_id.exists' => 'El productor con el ID especificado no existe.',
            'hr_total.required' => 'El campo total de horas es obligatorio.',
            'hr_total.numeric' => 'El campo total de horas debe ser un número decimal o entero.',
            'hr_prod.required' => 'El campo horas por productor es obligatorio.',
            'hr_prod.numeric' => 'El campo horas por productor debe ser un número decimal o entero.',
            'hr_prod.lte' => 'El campo horas por productor debe ser menor o igual al total de horas.',
            'place.required' => 'El campo lugar es obligatorio.',
            'place.string' => 'El campo lugar debe ser una cadena de texto.',
            'place.max' => 'El campo lugar no debe tener más de 1000 caracteres.',
        ]);

        Terrain::create([
            'productor_id' => $request->productor_id,
            'hr_total' => $request->hr_total,
            'hr_prod' => $request->hr_prod,
            'place' => $request->place
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Terrain $terrain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Terrain $terrain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Terrain $terrain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Terrain $terrain)
    {
        //
    }

    public function fetchOwner(Productor $productor){
        return $productor->terrains;
    }
}
