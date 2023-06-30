<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\UploadImage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('image/', function () {
    $file = UploadImage::get();
    return response()->json($file);
});


Route::get('image/{id}', function ($id) {
    $file = UploadImage::find($id);
    return response()->json($file);
});