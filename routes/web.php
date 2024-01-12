<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');

Route::get('/users/data', [App\Http\Controllers\UserController::class, 'getUsersData'])->name('users.data');

Route::post('/users/create', [App\Http\Controllers\UserController::class, 'store'])->name('users.create');

Route::post('/users/update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');

Route::get('/get-user/{id}', [App\Http\Controllers\UserController::class,'edit'])->name('user.edit');

Route::post('/user/update', [App\Http\Controllers\UserController::class,'update'])->name('user.update');

Route::post('/user/{id}', [App\Http\Controllers\UserController::class,'destroy'])->name('users.destroy');



Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');

Route::get('/roles/create', [App\Http\Controllers\RoleController::class,'create'])->name('roles.create');

Route::post('/roles', [App\Http\Controllers\RoleController::class,'store'])->name('roles.store');

Route::get('/get-role/{id}', [App\Http\Controllers\RoleController::class,'edit'])->name('roles.edit');

Route::post('/roles/update', [App\Http\Controllers\RoleController::class,'update'])->name('roles.update');

Route::post('/roles/{id}', [App\Http\Controllers\RoleController::class,'destroy'])->name('roles.destroy');



Route::post('/users/import', [App\Http\Controllers\UserController::class,'import'])->name('users.import');

Route::get('/export', [App\Http\Controllers\UserController::class,'export'])->name('export.index');

Route::get('/download', [UserController::class, 'downloadSample']);

Route::get('/import', [App\Http\Controllers\UploadsController::class, 'index'])->name('import.index');

Route::post('/import/{id}', [App\Http\Controllers\UploadsController::class,'destroy'])->name('import.destroy');
