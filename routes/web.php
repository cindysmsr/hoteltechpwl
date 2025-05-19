<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GuestInvoiceController;
use App\Http\Controllers\GuestReservationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/rooms/{roomType}', [RoomController::class, 'guestShow'])->name('room.detail');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('room_types')->group(function () {
        Route::get('/', [RoomTypeController::class,'index'])->name('room-types.index');
        Route::get('/create', [RoomTypeController::class,'create'])->name('room-types.create');
        Route::get('/show/{room_type}', [RoomTypeController::class,'show'])->name('room-types.show');
        Route::post('/store', [RoomTypeController::class,'store'])->name('room-types.store');
        Route::get('/edit/{room_type}', [RoomTypeController::class,'edit'])->name('room-types.edit');
        Route::put('/update/{room_type}', [RoomTypeController::class,'update'])->name('room-types.update');
        Route::delete('/destroy/{room_type}', [RoomTypeController::class,'destroy'])->name('room-types.destroy');
    });

    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/create', [RoomController::class,'create'])->name('rooms.create');
        Route::get('/show/{room}', [RoomController::class,'show'])->name('rooms.show');
        Route::post('/store', [RoomController::class,'store'])->name('rooms.store');
        Route::get('/edit/{room}', [RoomController::class,'edit'])->name('rooms.edit');
        Route::put('/update/{room}', [RoomController::class,'update'])->name('rooms.update');
        Route::delete('/destroy/{room}', [RoomController::class,'destroy'])->name('rooms.destroy');
    });

    Route::prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/create', [ReservationController::class,'create'])->name('reservations.create');
        Route::get('/show/{reservation}', [ReservationController::class,'show'])->name('reservations.show');
        Route::post('/store', [ReservationController::class,'store'])->name('reservations.store');
        Route::delete('/destroy', [ReservationController::class,'destroy'])->name('reservations.destroy');

        Route::get('/checkin/{reservation}', [ReservationController::class,'checkin'])->name('reservations.checkin');
        Route::get('/checkout/{reservation}', [ReservationController::class,'checkout'])->name('reservations.checkout');

        Route::patch('/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
        Route::patch('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

        Route::get('/show/{invoice}/invoice', [InvoiceController::class, 'show'])->name('reservations.invoices.show');
        Route::patch('/mark-paid/{invoice}', [InvoiceController::class, 'markAsPaid'])->name('reservations.invoices.mark-paid');
    });
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
//     Route::get('/profile', [ProfileController::class, 'index'])->name('guest.profile');
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
// });

Route::middleware(['auth', 'role:guest'])->group(function () {
    Route::prefix('guest')->group(function () {
        Route::prefix('reservations')->group(function () {
            Route::get('/search', [GuestReservationController::class, 'searchRooms'])->name('guest.reservations.search');
            Route::get('/create/{roomTypeId}', [GuestReservationController::class, 'createReservation'])->name('guest.reservations.create');
            Route::post('/store', [GuestReservationController::class, 'storeReservation'])->name('guest.reservations.store');
            
            Route::get('/{reservation}/confirmation', [GuestReservationController::class, 'showConfirmation'])->name('guest.reservation.confirmation');
            Route::get('/{reservation}/payment', [GuestReservationController::class, 'showPayment'])->name('guest.reservations.payment');
            Route::post('/{reservation}/process-payment', [GuestReservationController::class, 'processPayment'])->name('guest.reservations.processPayment');
            Route::get('/{reservation}/success', [GuestReservationController::class,'showSuccessPage'])->name('guest.reservations.success');

            Route::get('/list', [GuestReservationController::class, 'listReservations'])->name('guest.reservations.list');
            Route::get('/{reservation}', [GuestReservationController::class, 'showReservation'])->name('guest.reservations.show');
            Route::delete('/{reservation}/cancel', [GuestReservationController::class, 'cancelReservation'])->name('guest.reservations.cancel');
            Route::get('/{reservation}/review', [GuestReservationController::class, 'createReview'])->name('guest.reservations.review');
            Route::post('/{reservation}/storeReview', [GuestReservationController::class, 'storeReview'])->name('guest.reservations.reviewStore');
        });
        
        Route::prefix('invoice')->group(function () {
            Route::get('/{reservation}/show', [GuestInvoiceController::class,'show'])->name('guest.reservations.invoice');
            Route::get('/{reservation}/download', [GuestInvoiceController::class,'download'])->name('guest.invoices.download');
        });

        Route::get('/reviews', [ReviewController::class, 'index'])->name('guest.reviews.index');
    });
});

require __DIR__.'/auth.php';
