<?php

use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductorController;
use App\Http\Controllers\SealsController;
use App\Http\Controllers\TerrainController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/productors',[ProductorController::class,'index'])->name('productors');
Route::post('/productors/store',[ProductorController::class,'store'])->name('productors-store');

Route::get('/products',[ProductController::class,'index'])->name('products');
Route::post('/products/store',[ProductController::class,'store'])->name('product-store');
Route::get('/productors/fetch-query', [ProductorController::class, 'fetchQuery']);

Route::post('/terrains/store',[TerrainController::class,'store'])->name('terrains-store');

Route::get('/fetch/terrains/{productor}',[TerrainController::class,'fetchOwner'])->name('fetch-terrains-productor');
Route::get('/fetch/seals', [SealsController::class, 'fetch'])->name('fetch-seals');
Route::get('/fetch/products', [ProductController::class, 'fetch'])->name('fetch-seals');
Route::post('/fetch/adjustement', [ProductController::class, 'adjustement'])->name('adjustement');

Route::get('/procurements',[ProcurementController::class,'index'])->name('procurements');
Route::post('/procurements/store',[ProcurementController::class,'store'])->name('procurement-store');