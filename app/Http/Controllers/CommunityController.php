<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunityController extends Controller
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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $community = Community::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Community $community)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Community $community)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community)
    {
        //
    }

    public function fetchQuery(Request $request){
        $communities = Community::query()
            ->orderBy('name')
            ->filter($request->search)
            ->paginate(10)
            ->withQueryString()
            ->through(function ($community) {
                return [
                    'id' => $community->id,
                    'name' => $community->name,
                ];
            });

        return response()->json($communities);
    }
}
