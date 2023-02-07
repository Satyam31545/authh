<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\EducationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['login' => false, 'register' => false, 'logout' => false]);

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('/', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');

Route::get('family/{id}', [FamilyController::class, 'create'])->middleware('auth');
Route::post('family/{id}', [FamilyController::class, 'store'])->middleware('auth');

Route::get('education/{id}', [EducationController::class, 'create'])->middleware('auth');
Route::post('education/{id}', [EducationController::class, 'store'])->middleware('auth');

Route::resource('employee', EmployeeController::class)->middleware('auth');

Route::get('/update', [App\Http\Controllers\HomeController::class, 'update'])->middleware('auth');
Route::post('/update', [App\Http\Controllers\HomeController::class, 'p_update'])->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


