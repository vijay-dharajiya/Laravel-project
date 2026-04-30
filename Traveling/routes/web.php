<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Adminmiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [UserController::class, 'home'])->name('index');

/* Authenticated route for bookings*/
Route::middleware(['auth'])->group(function () {
    Route::get('/flight_booking/{id}', [UserController::class, 'flightbook'])->name('flight.book');
    /*flight booking route */
    Route::post('/flight_booking/{id}', [UserController::class, 'postflightbook'])->name('flightbooking');
    Route::get('/hotel_booking/{id}', [UserController::class, 'hotelbook'])->name('hotel.book');
});
/*hotel route */ 
Route::get('/hotelview/{id}', [UserController::class, 'hotelview'])->name('hotelview');



/*dashboard route for authenticated users*/
Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->group(function() {
    /*admin pages routes*/
    Route::get('/add_flight', [AdminController::class, 'addflight'])->name('admin.addflight');
    Route::get('/view_flight', [AdminController::class, 'viewflight'])->name('admin.viewflight');
    Route::get('/add_hotel', [AdminController::class, 'addhotel'])->name('admin.addhotel');
    Route::get('/view_hotel', [AdminController::class, 'viewhotel'])->name('admin.viewhotel');
    Route::get('/hotels_images', [AdminController::class, 'hotelimages'])->name('admin.hotelimages');
    Route::get('/hotel_room', [AdminController::class, 'hotelroom'])->name('admin.hotelroom');
    Route::get('/rooms_images', [AdminController::class, 'roomimages'])->name('admin.roomimages');

    /*admin flight crud routes*/
    Route::post('/add_flight', [AdminController::class,'postAddflight'])->name('admin.postaddflight');
    Route::get('/edit_flight/{id}', [AdminController::class, 'editflight'])->name('admin.editflight');
    Route::post('/edit_flight/{id}', [AdminController::class, 'posteditflight'])->name('admin.posteditflight');
    Route::delete('/delete_flight/{id}', [AdminController::class, 'deleteflight'])->name('admin.deleteflight');
    /*admin hotel crud routes*/
    Route::post('/add_hotel', [AdminController::class, 'hotelstore'])->name('admin.hotelstore');
    Route::get('/edit_hotel/{id}', [AdminController::class, 'edithotel'])->name('admin.edithotel');
    Route::post('/edit_hotel/{id}', [AdminController::class, 'postedithotel'])->name('admin.postedithotel');
    Route::delete('/delete_hotel/{id}', [AdminController::class, 'deletehotel'])->name('admin.deletehotel');
    /*admin hotel images routes*/
    Route::post('/hotels_images', [AdminController::class, 'hotelimagestore'])->name('hotel.images.store'); 
    /*admin hotel room routes*/
    Route::post('/hotel_room', [AdminController::class, 'hotelroomstore'])->name('admin.hotelroom.store');
    /*admin room images routes*/
    Route::post('/rooms_images', [AdminController::class, 'roomimagestore'])->name('admin.roomimages.store');
    // web.php
    Route::get('/admin/hotelimage/delete/{id}', [AdminController::class, 'deleteHotelImage'])
     ->name('admin.hotelimage.delete');
});

// ✅ Move this OUTSIDE the admin middleware group
Route::get('/rooms-by-hotel/{hotel_id}', [AdminController::class, 'getRoomsByHotel'])
    ->middleware('auth')
    ->name('admin.rooms.by.hotel');

require __DIR__.'/auth.php';
