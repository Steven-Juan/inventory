<?php

use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/pencatatan');

Route::prefix('pencatatan')->name('inventory.')->group(function (): void {
    Route::get('/', [InventoryController::class, 'index'])->name('index');
    Route::post('/barang', [InventoryController::class, 'storeItem'])->name('items.store');
    Route::post('/mutasi', [InventoryController::class, 'storeMovement'])->name('movements.store');
});

Route::prefix('laporan')->name('reports.')->group(function (): void {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/print', [ReportController::class, 'print'])->name('print');
    Route::get('/csv', [ReportController::class, 'csv'])->name('csv');
});

Route::prefix('komunikasi')->name('communication.')->group(function (): void {
    Route::get('/', [CommunicationController::class, 'index'])->name('index');
    Route::post('/pesan', [CommunicationController::class, 'store'])->name('store');
    Route::post('/pesan/{message}/dibaca', [CommunicationController::class, 'markRead'])->name('read');
});

