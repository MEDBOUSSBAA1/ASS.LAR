<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post("produit/store",[App\Http\Controllers\ProduitController::class,"store"]);
Route::get("produits",[App\Http\Controllers\ProduitController::class,"index"]);

Route::get("produit/{id}",[App\Http\Controllers\ProduitController::class,"show"]);
Route::post("produit/update/{id}",[App\Http\Controllers\ProduitController::class,"update"]);
Route::delete("produit/delete/{id}",[App\Http\Controllers\ProduitController::class,"destroy"]);
Route::post("produits/get",[App\Http\Controllers\ProduitController::class,"productbyid"]);


