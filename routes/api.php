<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('student', [StudentController::class,'getStudents']);
    Route::post('student', [StudentController::class,'createStudent']);
    Route::patch('student/{id}', [StudentController::class,'update']);
    Route::get('student/{id}', [StudentController::class,'findSingle']);
    Route::delete('student/{id}', [StudentController::class,'delete']);
});
// Route::patch('student/{id}', [StudentController::class,'update'])->middleware('auth:sanctum');
// users routes


// Route::get('student', [StudentController::class,'getStudents']);
// Route::post('student', [StudentController::class,'createStudent']);
// Route::patch('student/{id}', [StudentController::class,'update']);
// Route::get('student/{id}', [StudentController::class,'findSingle']);
// Route::delete('student/{id}', [StudentController::class,'delete']);


Route::post('user',[UserController::class,'createUser']);
Route::post('login',[UserController::class,'login']);
Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
