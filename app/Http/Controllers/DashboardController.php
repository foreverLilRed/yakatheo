<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Credit;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard',[
            'segmentacion' => Community::withCount('productors')->get()->map(function ($community) {
                return [
                    'name' => $community->name,
                    'count' => $community->productors_count,
                ];
            }),
            'sales' => Product::all()->map(function ($product) {
                return [
                    'name' => $product->name,
                    'count' => $product->earnings(),
                ];
            }),
            'credits' => Credit::with('payments')->get()->map(function ($credit) {
                $paidAmount = $credit->payments->sum('amount'); 
                return [
                    'id' => $credit->id,
                    'institution' => $credit->institution->name,
                    'total_amount' => $credit->total_amount,
                    'paid_amount' => $paidAmount,
                    'remaining_balance' => $credit->total_amount - $paidAmount,
                    'creado' => Carbon::parse($credit->created_at)->translatedFormat('j \d\e F \d\e\l Y')
                ];
            })
        ]);
    }
}
