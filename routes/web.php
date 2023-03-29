<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\LogController;
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

Auth::routes(['login' => false, 'register' => false]);

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('/', 'App\Http\Controllers\Auth\LoginController@login')->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/update', [EmployeeController::class, 'edit_s'])->name('user.edit');
    Route::put('/update', [EmployeeController::class, 'update_s'])->name('user.update');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

// for admin
    Route::resource('employee', EmployeeController::class);

    Route::get('/Role_update/{id}', [Roles::class, 'create'])->name('role.edit');
    Route::post('/Role_update/{id}', [Roles::class, 'store']);
    Route::get('/AllRole', [Roles::class, 'index'])->name('role.show');
    Route::resource('product', ProductController::class);
    Route::get('/product_deleted', [ProductController::class, 'products_delete'])->name('products_delete');
    Route::delete('/product_deleted_permanent/{product}', [ProductController::class, 'product_deleted_permanent'])->name('product_deleted_permanent');
    Route::get('/product_restore/{product}', [ProductController::class, 'product_restore'])->name('product_restore');
    Route::get('/fpdf', [ExportController::class, 'fpdf'])->name('pdf');
    Route::get('/myproduct', [HomeController::class, 'myproduct'])->name('user.product');
// increase assined product
// reject
    Route::get('/mylogs', [LogController::class, 'mylogs'])->name('logs');
// return assined product
    Route::get('/excel', [ExportController::class, 'excel_export'])->name('excel');
    Route::get('/myexcel_export', [ExportController::class, 'employee_product_export'])->name('assign.excel');

    Route::post('/return_assined', [AssignController::class, 'return_assined']);
    Route::post('/increase_assined', [AssignController::class, 'increase_assined']);
    Route::get('/deassign_product/{id}', [AssignController::class, 'destroy'])->name('deassign');
    Route::get('/assign_product/{employee}', [AssignController::class, 'create'])->name('assign');
    Route::post('/assign_product/{employee}', [AssignController::class, 'store']); 
    
});
