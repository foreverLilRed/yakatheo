<?php

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


Route::post('/terrains/store',[TerrainController::class,'store'])->name('terrains-store');

Route::get('/fetch/seals', [SealsController::class, 'fetch'])->name('fetch-seals');
