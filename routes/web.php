<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CarController;

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

Route::get('/', [ClientController::class, 'index']);

Route::resource('/client', ClientController::class);
Route::resource('/car', CarController::class);

Route::get('/list', [ClientController::class, 'list']);

Route::patch('/updateList', [CarController::class, 'updateList']);

Route::get('/getCars/{id}', [CarController::class, 'getCars']);