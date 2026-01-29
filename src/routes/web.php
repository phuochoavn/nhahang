<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['check.table'])->group(function () {
    Route::get('/', \App\Livewire\Client\Menu::class)->name('home');
    Route::get('/orders', \App\Livewire\Client\OrderHistory::class)->name('order.history');
});

Route::middleware([\App\Http\Middleware\KitchenGuard::class])->group(function () {
    Route::get('/kitchen', \App\Livewire\KitchenDashboard::class)->name('kitchen');
});

Route::get('/kitchen/login', \App\Livewire\KitchenLogin::class)->name('kitchen.login');

Route::get('/print-qr/{table}', [\App\Http\Controllers\TablePrintController::class, 'show'])->name('table.print_qr');
Route::get('/download-qr/{table}', [\App\Http\Controllers\TablePrintController::class, 'download'])->name('table.download_qr');
