<?php

use App\Http\Controllers\Add_Student;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\Delete_Student;
use App\Http\Controllers\Edit_Student;
use App\Http\Controllers\Fetch_Classes;
use App\Http\Controllers\Fetch_Sections;
use App\Http\Controllers\Fetch_Students;
use App\Http\Controllers\Fetch_Student_By_Id;
use Illuminate\Http\Request;

//Classes
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/Fetch_Students', [Fetch_Students::class, 'index']);
Route::delete('/Delete_Student/{id}', [Delete_Student::class, 'destroy']);
Route::post('/Fetch_Student_By_Id/{id}', [Fetch_Student_By_Id::class, 'edit']);
//Route::put('/Edit_Student/{id}',[Edit_Student::class , 'update']);

Route::post('/Edit_Student/{id}', [Edit_Student::class, 'update']);
Route::get('/Fetch_Sections', [Fetch_Sections::class, 'index']);
Route::post('/Add_Student', [Add_Student::class, 'store']);
Route::get('/Fetch_Classes', [Fetch_Classes::class, 'index']);

Route::resource('Classes', ClassesController::class);
