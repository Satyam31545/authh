<?php

use App\Http\Controllers\AssignController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IdCodeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
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

    Route::get('/Role_update/{id}', [RoleController::class, 'create'])->name('role.edit');
    Route::post('/Role_update/{id}', [RoleController::class, 'store']);
    Route::get('/AllRole', [RoleController::class, 'index'])->name('role.show');
    Route::resource('product', ProductController::class);
    Route::get('/product_deleted', [ProductController::class, 'deletedProducts'])->name('products_delete');
    Route::delete('/product_deleted_permanent/{product}', [ProductController::class, 'forceDelete'])->name('product_deleted_permanent');
    Route::get('/product_restore/{product}', [ProductController::class, 'restoreDeletedProduct'])->name('product_restore');
    Route::get('/fpdf', [ExportController::class, 'fpdf'])->name('pdf');
    Route::get('/myproduct', [HomeController::class, 'myproduct'])->name('user.product');
// increase assined product
    // reject
    Route::get('/mylogs', [LogController::class, 'mylogs'])->name('logs');
// return assined product
    Route::get('/excel', [ExportController::class, 'excel_export'])->name('excel');
    Route::get('/employee_product_export', [ExportController::class, 'employee_product_export'])->name('assign.excel');
    Route::get('/employee_product_download', [ExportController::class, 'employee_product_download'])->name('assign.download');

    Route::post('/return_assined', [AssignController::class, 'returnAssignedProduct']);
    Route::post('/increase_assined', [AssignController::class, 'increaseAssignedProduct']);
    Route::get('/deassign_product/{userAssignProduct}', [AssignController::class, 'deassignProduct'])->name('deassign');
    Route::get('/assign_product/{employee}', [AssignController::class, 'create'])->name('assign');
    Route::post('/assign_product/{employee}', [AssignController::class, 'assignProduct']);

    Route::get('/id_code', [IdCodeController::class, 'index'])->name('id_code.index');;
    Route::post('/id_code/{idCode}', [IdCodeController::class, 'update'])->name('id_code.update');

});
