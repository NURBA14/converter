<?php

use App\Http\Controllers\ConverterController;
use Illuminate\Support\Facades\Route;


Route::get("/", [ConverterController::class, "index"])->name("index");
Route::post("/store", [ConverterController::class, "store"])->name("store");