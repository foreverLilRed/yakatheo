<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{

    public function index()
    {
        return Inertia::render('Documents/Index');
    }
    public function procurement(Procurement $procurement)
    {

        $pdf = Pdf::loadView('documents.procurement', [
            'procurement' => $procurement
        ]);
        return $pdf->stream('procurement.pdf');
    }

    public function formCompromisoProduccion()
    {
        $actualDate = date('Y-m-d');
        return Inertia::render('Documents/CompromisoProduccion', [
            'data' => [
                'actualDate' => $actualDate
            ]
        ]);
    }

    public function storeCompromisoProduccion(Request $request)
    {
        $pdf = Pdf::loadView('documents.compromiso_produccion', [
            'nombres' => $request->nombres,
            'dni' => $request->dni,
            'domicilio' => $request->domicilio,
            'fecha' => Carbon::parse($request->fecha)->translatedFormat('j \d\e F, Y')
        ]);
        return $pdf->stream('compromiso_produccion.pdf');
    }

    public function formFichaControlInterno()
    {
        $actualDate = date('Y-m-d');
        return Inertia::render('Documents/FichaControlInterno', [
            'data' => [
                'actualDate' => $actualDate
            ]
        ]);
    }

    public function storeFichaControlInterno(Request $request)
    {
        $pdf = Pdf::loadView('documents.ficha_control_interno', [
            'fecha' => Carbon::parse(now())->translatedFormat('j \d\e F, Y')
        ]);
        return $pdf->stream('ficha_control_interno.pdf');
    }
}
