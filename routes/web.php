<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupportController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.start');
})->middleware('guest')->name('home');

Route::get('/privacy_policy', function () {
    return view('pages.privacyPolicy');
})->middleware('guest')->name('privacy');

Route::fallback(function () {
    return view('pages.404');
});

Route::get('/form', function () {
    return view('leads.form');
})->middleware('guest')->name('form');

/*
|--------------------------------------------------------------------------
| Internal Routes (Panel/Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Prospects
    Route::get('/prospects', [ContactController::class, 'index'])->name('prospects.index');
    Route::get('/prospects/lost', [ContactController::class, 'lost'])->name('prospects.lost');
    Route::get('/prospects/create', [ContactController::class, 'create'])->name('prospects.create');
    Route::post('/prospects', [ContactController::class, 'store'])->name('prospects.store');
    Route::get('/prospects/{contact}/edit', [ContactController::class, 'edit'])->name('prospects.edit');
    Route::put('/prospects/{contact}', [ContactController::class, 'update'])->name('prospects.update');
    Route::delete('/prospects/{contact}', [ContactController::class, 'destroy'])->name('prospects.destroy');
    Route::get('/prospects/{contact}/close', [ContactController::class, 'close'])->name('prospects.close');
    Route::post('/prospects/{contact}/close', [ContactController::class, 'generateInvoice'])->name('prospects.invoice.generate');

    // Contact notes
    Route::get('/prospects/{contact}/notes', [ContactNoteController::class, 'index'])->name('prospects.notes.index');
    Route::post('/prospects/{contact}/notes', [ContactNoteController::class, 'store'])->name('prospects.notes.store');
    Route::put('/prospects/{contact}/notes/{note}', [ContactNoteController::class, 'update'])->name('prospects.notes.update');
    Route::delete('/prospects/{contact}/notes/{note}', [ContactNoteController::class, 'destroy'])->name('prospects.notes.destroy');

    // Customers
    Route::get('/customers', [ContactController::class, 'customers'])->name('customers');
    Route::get('/customers/{contact}', [ContactController::class, 'show'])->name('customers.show');
    Route::get('/customers/{contact}/edit', [ContactController::class, 'customerEdit'])->name('customers.edit');
    Route::put('/customers/{contact}', [ContactController::class, 'customerUpdate'])->name('customers.update');
    Route::delete('/customers/{contact}', [ContactController::class, 'destroy'])->name('customers.destroy');

    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing');
    Route::get('/billing/{invoice}', [BillingController::class, 'show'])->name('billing.show');
    Route::put('/billing/{invoice}', [BillingController::class, 'update'])->name('billing.update');
    Route::delete('/billing/{invoice}', [BillingController::class, 'destroy'])->name('billing.destroy');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::get('/services/{service}/prices', [ServiceController::class, 'prices'])->name('services.prices');
    Route::post('/services/{service}/prices', [ServiceController::class, 'storePrice'])->name('services.prices.store');
    Route::delete('/services/{service}/prices/{price}', [ServiceController::class, 'destroyPrice'])->name('services.prices.destroy');
    Route::get('/services/{service}/prices/{price}/edit', [ServiceController::class, 'editPrice'])->name('services.prices.edit');
    Route::put('/services/{service}/prices/{price}', [ServiceController::class, 'updatePrice'])->name('services.prices.update');

    // Support
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');

    // Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';