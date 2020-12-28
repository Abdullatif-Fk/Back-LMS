<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\Fetch_Students;
use App\Http\Controllers\Delete_Student;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/Admins',[AdminsController::class, 'index']);

Route::post('/Fetch_Students',[Fetch_Students::class, 'index']);
Route::delete('/Delete_Student/{id}',[Delete_Student::class, 'destroy']);



