<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as RequestFacade;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Credits/Index', [
            'credits' => Credit::query()
                ->orderBy('total_amount')
                ->filter(RequestFacade::get('search'))
                ->paginate(15)
                ->withQueryString()
                ->through(fn($credit) => [
                    'id' => $credit->id,
                    'institucion' => $credit->institution->name,
                    'credito' => $credit->credit,
                    'tasa_interes' => $credit->interest_rate,
                    'monto_total' => $credit->total_amount,
                    'saldo_restante' => $credit->remaining_balance,
                    'fecha_prestamo' => $credit->loan_date,
                    'fecha_vencimiento' => $credit->due_date,
                    'estado' => match($credit->status){
                        Credit::STATUS_ACTIVE => 'Activo',
                        Credit::STATUS_PAID => 'Pagado',
                        Credit::STATUS_OVERDUE => 'Atrasado',
                    },
                    'moneda' => $credit->currency,
                    'proposito' => $credit->purpose
                ])
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
        $validated = $request->validate([
            'institution_id' => 'required|exists:institutions,id',
            'credit' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'loan_date' => 'required|date',
            'due_date' => 'required|date',
            'purpose' => 'nullable|string',
        ],[
            'institution_id.required' => 'El campo institución es obligatorio.',
            'institution_id.exists' => 'La institución seleccionada no es válida.',
            'credit.required' => 'El campo crédito es obligatorio.',
            'credit.numeric' => 'El campo crédito debe ser numérico.',
            'interest_rate.required' => 'El campo tasa de interés es obligatorio.',
            'interest_rate.numeric' => 'El campo tasa de interés debe ser numérico.',
            'total_amount.required' => 'El campo monto total es obligatorio.',
            'total_amount.numeric' => 'El campo monto total debe ser numérico.',
            'loan_date.required' => 'El campo fecha de préstamo es obligatorio.',
            'loan_date.date' => 'El campo fecha de préstamo debe ser una fecha válida.',
            'due_date.required' => 'El campo fecha de vencimiento es obligatorio.',
            'due_date.date' => 'El campo fecha de vencimiento debe ser una fecha válida.',
            'purpose.string' => 'El campo propósito debe ser una cadena de texto.',
        ]);

        Credit::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Credit $credit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Credit $credit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Credit $credit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credit $credit)
    {
        //
    }
}
