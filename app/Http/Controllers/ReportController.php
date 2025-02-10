<?php

namespace App\Http\Controllers;

use App\Exports\ProductorsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function productors(Request $request){
        return Excel::download(new ProductorsExport($request->all()),'productores.xlsx');
    }
}
