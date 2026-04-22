<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Adminmiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [UserController::class, 'home'])->name('index'); 

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->group(function() {
    Route::get('/add_flight', [AdminController::class, 'addflight'])->name('admin.addflight');
    Route::get('/view_flight', [AdminController::class, 'viewflight'])->name('admin.viewflight');
    Route::get('/add_hotel', [AdminController::class, 'addhotel'])->name('admin.addhotel');
    Route::get('/view_hotel', [AdminController::class, 'viewhotel'])->name('admin.viewhotel');
    Route::post('/add_flight', [AdminController::class,'postAddflight'])->name('admin.postaddflight');
    Route::get('/edit_flight/{id}', [AdminController::class, 'editflight'])->name('admin.editflight');
    Route::get('/delete_flight/{id}', [AdminController::class, 'deleteflight'])->name('admin.deleteflight');
    Route::post('/edit_flight/{id}', [AdminController::class, 'posteditflight'])->name('admin.posteditflight');
    Route::post('/add_hotel', [AdminController::class, 'postaddhotel'])->name('admin.postaddhotel');
});


require __DIR__.'/auth.php';
