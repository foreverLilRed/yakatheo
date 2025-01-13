<?php

namespace App\Http\Controllers;

use App\Events\PaymentCreated;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'credit_id' => 'required|exists:credits,id',
            'amount' => 'required|numeric',
        ],[
            'credit_id.required' => 'El campo crédito es obligatorio',
            'credit_id.exists' => 'El crédito seleccionado no existe',
            'amount.required' => 'El campo monto es obligatorio',
            'amount.numeric' => 'El campo monto debe ser un número',
        ]);

        $payment = Payment::create($validated);

        event(new PaymentCreated($payment));
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
