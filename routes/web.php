<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatImageController;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [CatImageController::class, 'index'])->name('catimages.cats');