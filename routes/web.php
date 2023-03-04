<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Roles;
use Illuminate\Support\Facades\Route;

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
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/update', [HomeController::class, 'edit'])->name('user.edit');
    Route::put('/update', [HomeController::class, 'update']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');

// for admin
    Route::resource('employee', EmployeeController::class);
    Route::get('/deassign_product/{id}', [HomeController::class, 'deassign_product'])->name('deassign');
    Route::get('/assign_product/{id}', [HomeController::class, 'assign_product'])->name('assign');
    Route::post('/assign_product/{id}', [HomeController::class, 'assign_product_p']);
    Route::get('/Role_update/{id}', [Roles::class, 'create'])->name('role.edit');
    Route::post('/Role_update/{id}', [Roles::class, 'store']);
    Route::get('/AllRole', [Roles::class, 'index'])->name('role.show');
    Route::resource('product', ProductController::class);
    Route::get('/fpdf', [ExportController::class, 'fpdf'])->name('pdf');
    Route::get('/myproduct', [HomeController::class, 'myproduct'])->name('user.product');
// increase assined product
    Route::post('/increase_assined', [HomeController::class, 'increase_assined']);
// reject
    Route::get('/mylogs', [HomeController::class, 'mylogs'])->name('logs');
// return assined product
    Route::post('/return_assined', [HomeController::class, 'return_assined']);
    Route::get('/excel', [ExportController::class, 'excel_export'])->name('excel');
});
