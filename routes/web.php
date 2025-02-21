<?php

use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CondicionesController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\NormasController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SealsController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\UploadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/productors',[ProductorController::class,'index'])->name('productors');
    Route::post('/productors/store',[ProductorController::class,'store'])->name('productors-store');
    Route::put('/productors/{productor}',[ProductorController::class,'update'])->name('productors-update');
    Route::get('/productors/fetch-query', [ProductorController::class, 'fetchQuery']);
    Route::get('/productors/{productor}',[ProductorController::class,'show'])->name('productors-show');
    
    Route::get('/products',[ProductController::class,'index'])->name('products');
    Route::post('/products/store',[ProductController::class,'store'])->name('product-store');
    Route::get('/products/fetch-query', [ProductController::class, 'fetchQuery']);
    
    Route::get('/communities/fetch-query', [CommunityController::class, 'fetchQuery']);
    
    Route::post('/terrains/store',[TerrainController::class,'store'])->name('terrains-store');
    Route::delete('/terrains/{terrain}',[TerrainController::class,'destroy'])->name('terrains-destroy');
    
    Route::get('/fetch/terrains/{productor}',[TerrainController::class,'fetchOwner'])->name('fetch-terrains-productor');
    Route::get('/fetch/seals', [SealsController::class, 'fetch'])->name('fetch-seals');
    Route::get('/fetch/normas', [NormasController::class, 'fetch'])->name('fetch-normas');
    Route::get('/fetch/condiciones', [CondicionesController::class, 'fetch'])->name('fetch-condiciones');
    Route::get('/fetch/products', [ProductController::class, 'fetch'])->name('fetch-seals');
    Route::post('/fetch/adjustement', [ProductController::class, 'adjustement'])->name('adjustement');
    
    Route::get('/procurements',[ProcurementController::class,'index'])->name('procurements');
    Route::post('/procurements/store',[ProcurementController::class,'store'])->name('procurement-store');
    
    Route::get('/documents/procurement/{procurement}', [DocumentController::class, 'procurement'])->name('document-procurement');
    
    Route::post('/buyers/store',[BuyerController::class,'store'])->name('buyer-store');
    Route::get('/buyers/fetch-query', [BuyerController::class, 'fetchQuery']);
    
    Route::post('/institutions/store',[InstitutionController::class,'store'])->name('institution-store');
    Route::get('/institutions/fetch-query',[InstitutionController::class,'fetchQuery']);
    
    Route::get('/sales',[SalesController::class,'index'])->name('sales');
    Route::post('/sales/store',[SalesController::class,'store'])->name('sales-store');
    Route::post('/sales/{sale}/document/upload',[SalesController::class,'upload'])->name('sales-document-store');
    
    Route::get('/credits',[CreditController::class,'index'])->name('credits');
    Route::post('/credits/store',[CreditController::class,'store'])->name('credits-store');
    
    Route::post('/payments/store',[PaymentsController::class,'store'])->name('payments-store');
    
    Route::get('/reports/productors',[ReportController::class,'productors']);
    
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');	
    Route::get('/documents/form/compromiso-produccion', [DocumentController::class, 'formCompromisoProduccion'])->name('compromiso-produccion');	
    Route::get('/documents/store/compromiso-produccion', [DocumentController::class, 'storeCompromisoProduccion'])->name('store-compromiso-produccion');	
    Route::get('/documents/form/ficha-control-interno', [DocumentController::class, 'formFichaControlInterno'])->name('ficha-control-interno');	
    Route::get('/documents/store/ficha-control-interno', [DocumentController::class, 'storeFichaControlInterno'])->name('store-ficha-control-interno');	
    
    
    Route::get('/uploads', [UploadController::class, 'index'])->name('uploads');
    Route::post('/uploads/store', [UploadController::class, 'store'])->name('uploads-store');
    Route::post('/communities/store',[CommunityController::class,'store'])->name('community-store');
});

Route::get('/productors/{productor}/limites',[ProductorController::class,'fetchLimites'])->name('productors-limites');
