<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Condicion;
use Illuminate\Http\Request;

class CondicionesController extends Controller
{
    public function fetch()
    {
        $condiciones = Condicion::all();
        return response()->json($condiciones);
    }
}
