<?php

use App\Http\Controllers\EmployeeController;
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

Route::get('/', [EmployeeController::class, 'index'])->name('emp.index');
Route::post('/addemp', [EmployeeController::class, 'store'])->name('emp.add');
Route::get('/allemp', [EmployeeController::class, 'allEmp'])->name('emp.all');
Route::get('/editEmp', [EmployeeController::class, 'editEmp'])->name('emp.edit');
Route::post('/updateEmp', [EmployeeController::class, 'updateEmp'])->name('emp.update');
Route::post('deleteEmp', [EmployeeController::class, 'deleteEmp'])->name('emp.delete');