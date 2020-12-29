<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\Fetch_Students;
use App\Http\Controllers\Delete_Student;
use App\Http\Controllers\Fetch_Student_By_Id;
use App\Http\Controllers\Edit_Student;




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/Admins',[AdminsController::class, 'index']);

Route::post('/Fetch_Students',[Fetch_Students::class, 'index']);
Route::delete('/Delete_Student/{id}',[Delete_Student::class, 'destroy']);
Route::post('/Fetch_Student_By_Id/{id}',[Fetch_Student_By_Id::class , 'edit']);
Route::put('/Edit_Student/{id}',[Edit_Student::class , 'update']);


