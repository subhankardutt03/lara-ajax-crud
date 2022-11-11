<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::controller(StudentController::class)
    ->prefix('student')
    ->as('student')
    ->group(function () {
        Route::get('/details', 'Index')->name('detail');
        Route::post('/add', 'StudentAdd')->name('add');
    });