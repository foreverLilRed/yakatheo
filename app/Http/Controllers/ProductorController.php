<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Productor;
use App\Models\Seal;
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
                    'nombres' => $productor->names,
                    'apellidos' => $productor->surnames,
                    'dni' => $productor->dni,
                    'nacimiento' => $productor->birthday,
                    'certificaciones' => $productor->seals->count(),
                    'tierras' => $productor->terrains->count()
                ])
        ]);
    }


    public function show()
    {
        $productors = Productor::paginate(15)->through(function ($productor) {
            return [
                'id' => $productor->id,
                'names' => $productor->names,
                'surnames' => $productor->surnames,
                'dni' => $productor->dni,
            ];
        });

        return Inertia::render('Productores/Index', ['productors' => $productors]);
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
        ]);
    
        if ($request->has('seal')) {
            $productor->seals()->sync($request->seal);
        }    
        
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
                    'balance' => $productor->balance()
                ];
            });

        return response()->json($productors);
    }

    
}
