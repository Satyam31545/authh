<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Roles;

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

Route::resource('employee', EmployeeController::class)->middleware('auth');

Route::get('/update', [App\Http\Controllers\HomeController::class, 'update'])->middleware('auth');
Route::post('/update', [App\Http\Controllers\HomeController::class, 'p_update'])->middleware('auth');
Route::get('/deassign_product/{id}', [App\Http\Controllers\HomeController::class, 'deassign_product'])->middleware('auth');
Route::get('/assign_product/{id}', [App\Http\Controllers\HomeController::class, 'assign_product'])->middleware('auth');
Route::post('/assign_product/{id}', [App\Http\Controllers\HomeController::class, 'assign_product_p'])->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/Role_update/{id}', [Roles::class, 'create'])->middleware('auth');
Route::post('/Role_update/{id}', [Roles::class, 'store'])->middleware('auth');
Route::get('/AllRole', [Roles::class, 'index'])->middleware('auth');


Route::resource('product', ProductController::class)->middleware('auth');




Route::get('/pdf/{id}', [App\Http\Controllers\HomeController::class, 'pdf'])->middleware('auth');
Route::get('/myproduct', [App\Http\Controllers\HomeController::class, 'myproduct'])->middleware('auth');

