<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstitutionController extends Controller
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
        Institution::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        //
    }

    public function fetchQuery(Request $request)
    {
        $institutions = Institution::query()
            ->orderBy('name')
            ->filter($request->search)
            ->paginate(10)
            ->withQueryString()
            ->through(function ($institution) {
                return [
                    'id' => $institution->id,
                    'nombre' => $institution->name
                ];
            });

        return response()->json($institutions);
    }
}
