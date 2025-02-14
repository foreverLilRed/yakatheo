<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Productor;
use App\Models\Seal;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Request as RequestFacade;

class ProductorController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Productors/Index', [
            'seals' => Seal::all(),
            'productors' => Productor::query()
                ->orderBy('names')
                ->filter(RequestFacade::get('search'))
                ->paginate(25)
                ->withQueryString()
                ->through(fn($productor) => [
                    'id' => $productor->id,
                    'nombres' => $productor->names ?? 'No registrado',
                    'apellidos' => !empty($productor->surnames) ? $productor->surnames : 'No registrado',
                    'socio' => (bool) $productor->socio ? 'Si' : 'No',
                    'dni' => $productor->dni ?? 'No registrado',
                    'nacimiento' => $productor->birthday ? Carbon::parse($productor->birthday)->translatedFormat('j \d\e F, Y') : 'No registrado',
                    'certificaciones' => $productor->seals->count(),
                    'tierras' => $productor->terrains->count(),
                    'info' => [
                        'certificaciones' => $productor->seals->pluck('name')
                    ],
                    'ventas' => $productor->procurements->count(),
                ])
        ]);
    }


    public function show(Productor $productor)
    {
        $acopios = $productor->procurements; 

        $acopiosPorProducto = $acopios->groupBy('product.name')->map(function ($grupo, $nombreProducto) {
            return [
                'id' => $grupo->first()->product->id,
                'nombre' => $nombreProducto, 
                'fechas' => $grupo->pluck('created_at')->map(fn($fecha) => Carbon::parse($fecha)->format('d/m/Y')),
                'totales' => $grupo->map(fn($acopio) => $acopio->total()),
            ];
        });
        return Inertia::render('Productors/Show', [
            'data' => $productor,
            'comunidad' => $productor->community ?? null,
            'tierras' => $productor->terrains ?? null,
            'sellos' => $productor->seals()->pluck('seals.id'),
            'acopios' => $acopiosPorProducto,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'names' => 'required|string|max:255',
                'surnames' => 'required|string|max:255',
                'dni' => 'required|digits:8', 
                'birthday' => 'required|date',
                'seal.*' => 'exists:seals,id', 
                'community_id' => 'required|exists:communities,id'
            ],
            [
                'names.required' => 'El campo nombres es obligatorio.',
                'names.string' => 'El campo nombres debe ser una cadena de texto.',
                'names.max' => 'El campo nombres no debe tener más de 255 caracteres.',
                'surnames.required' => 'El campo apellidos es obligatorio.',
                'surnames.string' => 'El campo apellidos debe ser una cadena de texto.',
                'surnames.max' => 'El campo apellidos no debe tener más de 255 caracteres.',
                'dni.required' => 'El campo DNI es obligatorio.',
                'dni.digits' => 'El campo DNI debe tener exactamente 8 dígitos.', // Mensaje para 'digits'
                'birthday.required' => 'El campo fecha de nacimiento es obligatorio.',
                'birthday.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            ]
        );

        $productor = Productor::create([
            'names' => $request->names,
            'surnames' => $request->surnames,
            'dni' => $request->dni,
            'birthday' => $request->birthday,
            'community_id' => $request->community_id
        ]);
    
        if ($request->has('seal')) {
            $productor->seals()->sync($request->seal);
        }    
        
    }

    public function update(Request $request, Productor $productor){
        $validated = $request->validate(
            [
                'names' => 'required|string|max:255',
                'surnames' => 'nullable|string|max:255',
                'dni' => 'nullable|digits:8', 
                'birthday' => 'nullable|date',
                'socio' => 'nullable|boolean',
                'seal.*' => 'exists:seals,id', 
                'community_id' => 'required|exists:communities,id'
            ],
            [
                'names.required' => 'El campo nombres es obligatorio.',
                'names.string' => 'El campo nombres debe ser una cadena de texto.',
                'names.max' => 'El campo nombres no debe tener más de 255 caracteres.',
                'surnames.string' => 'El campo apellidos debe ser una cadena de texto.',
                'surnames.max' => 'El campo apellidos no debe tener más de 255 caracteres.',
                'dni.digits' => 'El campo DNI debe tener exactamente 8 dígitos.',
                'birthday.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            ]
            );

        $productor->update(collect($validated)->except(['seal'])->toArray());

        $productor->seals()->sync($request->seal ?? []);
    }

    public function fetchQuery(Request $request){
        $productors = Productor::query()
            ->orderBy('names')
            ->filter($request->search)
            ->paginate(15)
            ->withQueryString()
            ->through(function ($productor) {
                return [
                    'id' => $productor->id,
                    'nombres' => $productor->names,
                    'apellidos' => $productor->surnames,
                    'dni' => $productor->dni,
                    'nacimiento' => $productor->birthday,
                    'certificaciones' => $productor->seals->count(),
                    'tierras' => $productor->terrains->count(),
                ];
            });

        return response()->json($productors);
    }

    
}
