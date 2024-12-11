<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;

Route::get('/', function () {
    return view('createp');
});
// Route::Post('/posts', [ProduitController::class, 'store'])->name('produit.store');

// Route::get('/index', [ProduitController::class, 'index'])->name('produit.index');

