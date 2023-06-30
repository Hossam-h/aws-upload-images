<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\UploadImage;
use App\Http\Controllers\UploadImageController;
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


Route::get('/all', [UploadImageController::class,'all']);


Route::get('/', [UploadImageController::class,'index']);

Route::post('upload-file',  [UploadImageController::class,'store'])->name('upload-file');

Route::get('delete-file/{id}', [UploadImageController::class,'destroy'])->name('delete-file');

Route::get('download-file/{id}', [UploadImageController::class,'download'] )->name('download');

