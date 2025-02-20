<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Norma;
use Illuminate\Http\Request;

class NormasController extends Controller
{
    public function fetch()
    {
        $normas = Norma::all();
        return response()->json($normas);
    }
}
