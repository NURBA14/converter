<?php

use App\Http\Controllers\ConverterController;
use Illuminate\Support\Facades\Route;


Route::post("convert", [ConverterController::class, "convert"]);