<?php

use App\Http\Controllers\Api\EmployeeApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\FamilyApiController;
use App\Http\Controllers\Api\EducationApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

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
Route::post("login", [UserApiController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('products', ProductApiController::class);
    Route::apiResource('employees', EmployeeApiController::class);
    Route::get("user", [UserApiController::class, 'user']);
    Route::post("family", [FamilyApiController::class, 'store']);
    Route::post("education", [EducationApiController::class, 'store']);

});
