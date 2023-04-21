<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->as('dashboard.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/' , function(){
        return view('dashboard.index');
    })->name('index');
    // Route::get('/', [DashboardController::class , 'index'])->name('index');
    Route::get('page/{name}', [DashboardController::class , 'page'])->name('page');

    // =====================================
    // ============ Categories =============
    // =====================================
    Route::resource('categories', CategoryController::class)->except(['show' ,'edit' , 'create']);
    Route::get('categories/{category}/active' , [CategoryController::class , 'toggleActive'])->name('categories.toggle');

});
