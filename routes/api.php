<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/add_book', [BookController::class,'create']);
Route::get('/get_all_books', [BookController::class,'show']);
Route::get('/get_details/{id}', [BookController::class,'edit']);
Route::post('/update_book/{id}', [BookController::class,'update']);
Route::get('/search_books',[BookController::class,'search']);
Route::get('/delete_book/{id}',[BookController::class,'delete']);