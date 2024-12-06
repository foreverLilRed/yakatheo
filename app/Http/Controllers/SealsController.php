<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Seal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SealsController extends Controller
{
    public function fetch()
    {
        $seals = Seal::all();
        return response()->json($seals);
    }
}
