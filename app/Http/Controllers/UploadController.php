<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\UploadImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function index()
    {
        return Inertia::render('Uploads/Index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048', // Solo acepta .xlsx y hasta 2MB
        ]);

        set_time_limit(300);
        Excel::import(new UploadImport($request->socios, $request->fecha, $request->inicio, $request->fin), $request->file);
    }
}
