<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UrlController::class, 'index'])->name('home');
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/shorten', [UrlController::class, 'store'])->name('shorten');
});
Route::get('/{code}', [UrlController::class, 'redirect'])->name('redirect');
