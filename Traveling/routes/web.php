<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home page — shows trending flights + hotels
Route::get('/', [UserController::class, 'home'])->name('index');

Route::get('/flight_details', [UserController::class, 'flightdetailview'])->name('flights.detailview');
// Airport autocomplete (AJAX) — used by search box
Route::get('/airports/search', [UserController::class, 'searchAirports'])->name('airports.search');

// Flight search results page
Route::get('/flights/search', [UserController::class, 'search'])->name('flight.search');

// Flight detail + booking page
Route::get('/flights/{id}', [UserController::class, 'flightdetails'])->name('flight.details');

// Hotel detail page
Route::get('/hotel/{id}', [UserController::class, 'hotelview'])->name('hotelview');
/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Post flight booking
    Route::post('/flight/book', [UserController::class, 'store'])->name('flight.book');
    Route::get('/flight/booking/{booking}/confirmation', [UserController::class, 'confirmation'])->name('flight.booking.confirmation');
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('verified')->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->group(function () {

    // Flight CRUD
    Route::get('/add_flight', [AdminController::class, 'addflight'])->name('admin.addflight');
    Route::post('/add_flight', [AdminController::class, 'postAddflight'])->name('admin.postaddflight');
    Route::get('/view_flight', [AdminController::class, 'viewflight'])->name('admin.viewflight');
    Route::get('/edit_flight/{id}', [AdminController::class, 'editflight'])->name('admin.editflight');
    Route::post('/edit_flight/{id}', [AdminController::class, 'posteditflight'])->name('admin.posteditflight');
    Route::get('/delete_flight/{id}', [AdminController::class, 'deleteflight'])->name('admin.deleteflight');

    // Hotel CRUD
    Route::get('/add_hotel', [AdminController::class, 'addhotel'])->name('admin.addhotel');
    Route::post('/add_hotel', [AdminController::class, 'hotelstore'])->name('admin.hotelstore');
    Route::get('/view_hotel', [AdminController::class, 'viewhotel'])->name('admin.viewhotel');
    Route::get('/edit_hotel/{id}', [AdminController::class, 'edithotel'])->name('admin.edithotel');
    Route::post('/edit_hotel/{id}', [AdminController::class, 'postedithotel'])->name('admin.postedithotel');
    Route::get('/delete_hotel/{id}', [AdminController::class, 'deletehotel'])->name('admin.deletehotel');

    // Hotel Images
    Route::get('/hotels_images', [AdminController::class, 'hotelimages'])->name('admin.hotelimages');
    Route::post('/hotels_images', [AdminController::class, 'hotelimagestore'])->name('hotel.images.store');
    Route::get('/admin/hotelimage/delete/{id}', [AdminController::class, 'deleteHotelImage'])->name('admin.hotelimage.delete');

    // Hotel Rooms
    Route::get('/hotel_room', [AdminController::class, 'hotelroom'])->name('admin.hotelroom');
    Route::post('/hotel_room', [AdminController::class, 'hotelroomstore'])->name('admin.hotelroom.store');

    // Room Images
    Route::get('/rooms_images', [AdminController::class, 'roomimages'])->name('admin.roomimages');
    Route::post('/rooms_images', [AdminController::class, 'roomimagestore'])->name('admin.roomimages.store');

    // Flight Classes
    Route::get('/flight/{flightId}/classes', [AdminController::class, 'flightClassIndex'])->name('admin.flightclass.index');
    Route::get('/flight/{flightId}/classes/create', [AdminController::class, 'flightClassCreate'])->name('admin.flightclass.create');
    Route::post('/flight/{flightId}/classes/store', [AdminController::class, 'flightClassStore'])->name('admin.flightclass.store');
    Route::get('/flight_class/{id}/edit', [AdminController::class, 'flightClassEdit'])->name('admin.flightclass.edit');
    Route::post('/flight_class/{id}/update', [AdminController::class, 'flightClassUpdate'])->name('admin.flightclass.update');
    Route::get('/flight_class/{id}/delete', [AdminController::class, 'flightClassDestroy'])->name('admin.flightclass.destroy');

    // Flight Schedules
    Route::get('/flight/{flightId}/schedules', [AdminController::class, 'flightScheduleIndex'])->name('admin.flightschedule.index');
    Route::post('/flight/{flightId}/schedules/generate', [AdminController::class, 'flightScheduleGenerate'])->name('admin.flightschedule.generate');
    Route::post('/flight_schedule/{id}/status', [AdminController::class, 'flightScheduleUpdateStatus'])->name('admin.flightschedule.status');
    Route::get('/flight_schedule/{id}/delete', [AdminController::class, 'flightScheduleDestroy'])->name('admin.flightschedule.destroy');
    Route::get('/flight/{flightId}/schedules/cleanup', [AdminController::class, 'flightScheduleCleanup'])->name('admin.flightschedule.cleanup');
});

// Rooms by hotel (auth only, not admin-only)
Route::get('/rooms-by-hotel/{hotel_id}', [AdminController::class, 'getRoomsByHotel'])
    ->middleware('auth')
    ->name('admin.rooms.by.hotel');

require __DIR__.'/auth.php';
