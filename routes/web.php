<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Route::group(['middleware' => ['isAdmin','auth'],'prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class);
    Route::delete('rooms_mass_destroy', [\App\Http\Controllers\Admin\RoomController::class, 'massDestroy'])->name('rooms.mass_destroy');
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class);
    Route::delete('bookings_mass_destroy', [\App\Http\Controllers\Admin\BookingController::class, 'massDestroy'])->name('bookings.mass_destroy');

    Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);
    Route::delete('doctors_mass_destroy', [\App\Http\Controllers\Admin\DoctorController::class, 'massDestroy'])->name('doctors.mass_destroy');

    Route::get('find_rooms', [\App\Http\Controllers\Admin\FindRoomController::class, 'index'])->name('find_rooms.index');
    Route::post('find_rooms', [\App\Http\Controllers\Admin\FindRoomController::class, 'index']);

    Route::get('system_calendars', [\App\Http\Controllers\Admin\SystemCalendarController::class, 'index'])->name('system_calendars.index');
});


Auth::routes();

