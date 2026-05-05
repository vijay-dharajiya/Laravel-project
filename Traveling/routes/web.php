<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Adminmiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [UserController::class, 'home'])->name('index');

/* Authenticated route for bookings*/
Route::middleware(['auth'])->group(function () {
    /*flight booking route */
    Route::post('/flight_booking/{id}', [UserController::class, 'postflightbook'])->name('flightbooking');
    Route::get('/hotel_booking/{id}', [UserController::class, 'hotelbook'])->name('hotel.book');
});
//flight details route
Route::get('/flight_show/{id}', [UserController::class, 'flightdetails'])->name('flight.details');
//flight search route
Route::get('/airports/search', [UserController::class, 'searchAirports'])->name('airports.search');
Route::get('/flights/search', [UserController::class, 'searchFlights'])->name('flight.search');
/*hotel route */ 
Route::get('/hotelview/{id}', [UserController::class, 'hotelview'])->name('hotelview');



/*dashboard route for authenticated users*/
Route::get('/dashboard', [UserController::class, 'index1'])->middleware(['auth', 'verified'])->name('dashboard');


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
    Route::get('/delete_flight/{id}', [AdminController::class, 'deleteflight'])->name('admin.deleteflight');
    /*admin hotel crud routes*/
    Route::post('/add_hotel', [AdminController::class, 'hotelstore'])->name('admin.hotelstore');
    Route::get('/edit_hotel/{id}', [AdminController::class, 'edithotel'])->name('admin.edithotel');
    Route::post('/edit_hotel/{id}', [AdminController::class, 'postedithotel'])->name('admin.postedithotel');
    Route::get('/delete_hotel/{id}', [AdminController::class, 'deletehotel'])->name('admin.deletehotel');
    /*admin hotel images routes*/
    Route::post('/hotels_images', [AdminController::class, 'hotelimagestore'])->name('hotel.images.store'); 
    /*admin hotel room routes*/
    Route::post('/hotel_room', [AdminController::class, 'hotelroomstore'])->name('admin.hotelroom.store');
    /*admin room images routes*/
    Route::post('/rooms_images', [AdminController::class, 'roomimagestore'])->name('admin.roomimages.store');
    // web.php
    Route::get('/admin/hotelimage/delete/{id}', [AdminController::class, 'deleteHotelImage'])
     ->name('admin.hotelimage.delete');

     /*================== FLIGHT CLASS ROUTES ==================*/

    // View all classes of a flight
    Route::get('/flight/{flightId}/classes', [AdminController::class, 'flightClassIndex'])
        ->name('admin.flightclass.index');

    // Show add form
    Route::get('/flight/{flightId}/classes/create', [AdminController::class, 'flightClassCreate'])
        ->name('admin.flightclass.create');

    // Store classes
    Route::post('/flight/{flightId}/classes/store', [AdminController::class, 'flightClassStore'])
        ->name('admin.flightclass.store');

    // Edit one class
    Route::get('/flight_class/{id}/edit', [AdminController::class, 'flightClassEdit'])
        ->name('admin.flightclass.edit');

    // Update one class
    Route::post('/flight_class/{id}/update', [AdminController::class, 'flightClassUpdate'])
        ->name('admin.flightclass.update');

    // Delete one class
    Route::get('/flight_class/{id}/delete', [AdminController::class, 'flightClassDestroy'])
        ->name('admin.flightclass.destroy');

        /*================== FLIGHT SCHEDULE ROUTES ==================*/

    // View all schedules of a flight
    Route::get('/flight/{flightId}/schedules', [AdminController::class, 'flightScheduleIndex'])
        ->name('admin.flightschedule.index');

    // Generate 30/60/90 day schedules
    Route::post('/flight/{flightId}/schedules/generate', [AdminController::class, 'flightScheduleGenerate'])
        ->name('admin.flightschedule.generate');

    // Update status of single schedule
    Route::post('/flight_schedule/{id}/status', [AdminController::class, 'flightScheduleUpdateStatus'])
        ->name('admin.flightschedule.status');

    // Delete single schedule
    Route::get('/flight_schedule/{id}/delete', [AdminController::class, 'flightScheduleDestroy'])
        ->name('admin.flightschedule.destroy');

    // Cleanup all past schedules
    Route::get('/flight/{flightId}/schedules/cleanup', [AdminController::class, 'flightScheduleCleanup'])
        ->name('admin.flightschedule.cleanup');
});

// ✅ Move this OUTSIDE the admin middleware group
Route::get('/rooms-by-hotel/{hotel_id}', [AdminController::class, 'getRoomsByHotel'])
    ->middleware('auth')
    ->name('admin.rooms.by.hotel');

require __DIR__.'/auth.php';
