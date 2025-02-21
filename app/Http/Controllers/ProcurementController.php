<?php

namespace App\Http\Controllers;

use App\Events\ProcurementEntered;
use App\Exceptions\LimiteDeProduccion;
use App\Models\Procurement;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Productor;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acopios_por_producto = Product::withCount('procurements')->get();
        return Inertia::render('Procurements/Index', [
            'procurements' => Procurement::query()
                ->with(['productor.community', 'product'])
                ->orderBy('weight')
                ->filter(RequestFacade::get('search'))
                ->paginate(15)
                ->withQueryString()
                ->through(fn($procurement) => [
                    'id' => $procurement->id,
                    'weight' => $procurement->weight,
                    'unit_price' => $procurement->unit_price,
                    'product' => $procurement->product,
                    'productor' => $procurement->productor ?? 'No identificado',
                    'comunidad' => $procurement->productor->community->name ?? 'No identificado',
                    'total' => $procurement->total(),
                ]),
            'segmentacion' => [
                'acopios_por_producto' => $acopios_por_producto->map(function ($item) {
                    return [
                        'x' => $item->name,
                        'y' => $item->procurements_count
                    ];
                }),
                'cantidad_mes_actual' =>  Procurement::where('created_at', '>=', now()->startOfMonth())->count(),
                'cantidad_mes_pasado' => Procurement::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count(),
                'costo_mes' => Procurement::where('created_at', '>=', now()->startOfMonth())->get()->sum(fn($acopio) => $acopio->total()),
                'tops' => [
                    'mes' => Productor::withCount([
                        'procurements' => function ($query) {
                            $query->where('created_at', '>=', now()->startOfMonth());
                        }
                    ])
                        ->orderByDesc('procurements_count')
                        ->limit(5)
                        ->get(['id', 'name', 'procurements_count']),

                    'total' => Productor::withCount('procurements')
                        ->orderByDesc('procurements_count')
                        ->limit(5)
                        ->get(['id', 'name', 'procurements_count']),
                ],
                'precios_promedios' => Product::all()->map(function ($producto) {
                    return [
                        'producto' => $producto->name,
                        'promedio' => round($producto->precio_promedio(), 2)
                    ];
                })

            ]
        ]);
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
            'product_id' => 'required|exists:products,id',
            'productor_id' => 'required|exists:productors,id',
            'weight' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0.01',
        ], [
            'product_id.required' => 'El campo producto es obligatorio.',
            'product_id.exists' => 'El producto con el ID especificado no existe.',
            'productor_id.required' => 'El campo productor es obligatorio.',
            'productor_id.exists' => 'El productor con el ID especificado no existe.',
            'weight.required' => 'El campo peso es obligatorio.',
            'weight.numeric' => 'El campo peso debe ser un número decimal o entero.',
            'weight.min' => 'El campo peso debe ser mayor a 0.',
            'unit_price.required' => 'El campo precio unitario es obligatorio.',
            'unit_price.numeric' => 'El campo precio unitario debe ser un número decimal o entero.',
            'unit_price.min' => 'El campo precio unitario debe ser mayor a 0.'
        ]);

        try {
            $productor = Productor::findOrFail($request->productor_id);
    
            $productor->limite($request->product_id, $request->weight);
    
            $procurement = Procurement::create($request->all());
    
            event(new ProcurementEntered($procurement));
    
            return redirect()->back()->with('success', 'Procurement registrado correctamente');
        } catch (LimiteDeProduccion $e) {
            return redirect()->back()->with('error', $e->getMessage().': '.$productor->produccionAnual($request->product_id));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error inesperado: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Procurement $procurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procurement $procurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procurement $procurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procurement $procurement)
    {
        //
    }
}
