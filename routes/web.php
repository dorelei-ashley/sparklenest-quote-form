<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('quote.form');
});

Route::view('/quote', 'quote')->name('quote.form');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
Route::view('/thank-you', 'thank-you')->name('quote.thanks');