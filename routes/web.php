<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return response()->json([
        "status"    =>  "success",
        "version"   =>  "2023.10.1"
    ]);
});

// Route::fallback(function () {
//     return response(File::get("index.html"), 404);
// });