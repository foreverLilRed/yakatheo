<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function procurement(Procurement $procurement){
        
        $pdf = Pdf::loadView('documents.procurement', [
            'procurement' => $procurement
        ]);
        return $pdf->stream('procurement.pdf');
    }
}
