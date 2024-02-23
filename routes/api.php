<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendantController;

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
Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    
Route::post('create-user',[UserAuthController::class,'create'])->name('create-user');
Route::post('login',[UserAuthController::class,'login'])->name('login');
Route::post('forgot-password',[UserAuthController::class,'forgetPassword']);
});

Route::post('logout',[UserAuthController::class,'logout'])->middleware('auth:sanctum');

#route for employee crud that aunothorized to some users
Route::group(['namespace' => 'Api', 'prefix' => 'v1','middleware' => 'auth:sanctum'], function () {
Route::post('create-emp',[EmployeeController::class,'store']);
Route::post('update-emp',[EmployeeController::class,'update'])->name('update-emp');
});
#Route for attendant operation
Route::group(['namespace' => 'Api', 'prefix' => 'v1','middleware' => 'auth:sanctum'], function () {
    Route::post('started_at',[AttendantController::class,'store']);
    Route::post('ended_at',[AttendantController::class,'update']);
    });

    #route for employee  that are open  users
Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::get('employee',[EmployeeController::class,'index']);
    Route::get('attendance',[AttendantController::class,'index']);
    Route::get('attendancePDFReport',[AttendantController::class,'PDFReport']);
    Route::get('excelReport',[AttendantController::class,'ExcelReport']);
    });