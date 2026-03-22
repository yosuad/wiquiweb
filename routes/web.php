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

// ===== Páginas públicas =====
Route::get('/', function () {
    return view('pages.start');
})->middleware('guest')->name('home');

// ===== Servicios diseño paginas web =====
Route::get('/servicios/diseno-web', function () {
    return view('pages.services.web-design');
})->name('services.web-design');

// ===== Legal =====
Route::get('/privacy_policy', function () {
    return view('pages.privacyPolicy');
})->middleware('guest')->name('privacy');

// ===== Leads (formulario pagina start) =====
Route::post('/contacto', [ContactController::class, 'formstartstore'])->name('leads.store');

// ===== Leads (formulario público Meta) =====
Route::get('/form', function () {
    return view('leads.form');
})->middleware('guest')->name('form');

Route::post('/form', [ContactController::class, 'leadStore'])->name('leads.meta.store');



/*
|--------------------------------------------------------------------------
| Internal Routes (Panel/Admin)
| Middleware: auth + verified + approved
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'approved'])->group(function () {

    // ── Dashboard ── (todos los roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Prospects ── (permission: view prospects)
    // administrator, agent, sales-agent
    Route::middleware('permission:view prospects')->group(function () {
        Route::get('/prospects', [ContactController::class, 'index'])->name('prospects.index');
        Route::get('/prospects/lost', [ContactController::class, 'lost'])->name('prospects.lost');
        Route::get('/prospects/{contact}/edit', [ContactController::class, 'edit'])->name('prospects.edit');
        Route::put('/prospects/{contact}', [ContactController::class, 'update'])->name('prospects.update');
        Route::get('/prospects/{contact}/close', [ContactController::class, 'close'])->name('prospects.close');
        Route::post('/prospects/{contact}/close', [ContactController::class, 'generateInvoice'])->name('prospects.invoice.generate');
    });

    Route::middleware('permission:create prospects')->group(function () {
        Route::get('/prospects/create', [ContactController::class, 'create'])->name('prospects.create');
        Route::post('/prospects', [ContactController::class, 'store'])->name('prospects.store');
    });

    Route::middleware('permission:delete prospects')->group(function () {
        Route::delete('/prospects/{contact}', [ContactController::class, 'destroy'])->name('prospects.destroy');
    });

    // ── Contact Notes ── (permission: view prospects)
    Route::middleware('permission:view prospects')->group(function () {
        Route::get('/prospects/{contact}/notes', [ContactNoteController::class, 'index'])->name('prospects.notes.index');
        Route::post('/prospects/{contact}/notes', [ContactNoteController::class, 'store'])->name('prospects.notes.store');
        Route::put('/prospects/{contact}/notes/{note}', [ContactNoteController::class, 'update'])->name('prospects.notes.update');
        Route::delete('/prospects/{contact}/notes/{note}', [ContactNoteController::class, 'destroy'])->name('prospects.notes.destroy');
    });

    // ── Customers ── (permission: view customers)
    // administrator, agent, sales-agent, billing-agent
    Route::middleware('permission:view customers')->group(function () {
        Route::get('/customers', [ContactController::class, 'customers'])->name('customers');
        Route::get('/customers/{contact}', [ContactController::class, 'show'])->name('customers.show');
    });

    Route::middleware('permission:edit customers')->group(function () {
        Route::get('/customers/{contact}/edit', [ContactController::class, 'customerEdit'])->name('customers.edit');
        Route::put('/customers/{contact}', [ContactController::class, 'customerUpdate'])->name('customers.update');
        Route::patch('/customers/service/{contactService}/status', [ContactController::class, 'updateServiceStatus'])->name('customers.service.status');
        Route::patch('/customers/service/{contactService}/description', [ContactController::class, 'updateServiceDescription'])->name('customers.service.description');
        Route::patch('/customers/{contact}/message-sent', [ContactController::class, 'toggleMessageSent'])->name('contacts.message.toggle');
        // billing.update aquí para que agentes puedan actualizar facturas desde customers.show
        Route::put('/billing/{invoice}', [BillingController::class, 'update'])->name('billing.update');
    });

    Route::middleware('permission:delete customers')->group(function () {
        Route::delete('/customers/{contact}', [ContactController::class, 'destroy'])->name('customers.destroy');
    });

    // ── Billing ── (permission: view billing)
    // administrator, billing-agent
    Route::middleware('permission:view billing')->group(function () {
        Route::get('/billing', [BillingController::class, 'index'])->name('billing');
        Route::get('/billing/{contact}/invoices', [BillingController::class, 'show'])->name('billing.show');
        Route::get('/billing/{invoice}/invoice', [BillingController::class, 'invoice'])->name('billing.invoice');
    });

    Route::middleware('permission:edit billing')->group(function () {
        Route::delete('/billing/{invoice}', [BillingController::class, 'destroy'])->name('billing.destroy');
    });

    // ── Services ── (solo administrator)
    Route::middleware('role:administrator')->group(function () {
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
    });

    // ── Support ── (permission: view support)
    // administrator, support
    // IMPORTANTE: /support/create debe ir antes de /support/{ticket}
    Route::middleware('permission:view support')->group(function () {
        Route::get('/support', [SupportController::class, 'index'])->name('support');
        Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
        Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');
    });

    Route::middleware('permission:edit support')->group(function () {
        Route::post('/support', [SupportController::class, 'store'])->name('support.store');
        Route::put('/support/{ticket}', [SupportController::class, 'update'])->name('support.update');
        Route::delete('/support/{ticket}', [SupportController::class, 'destroy'])->name('support.destroy');
        Route::post('/support/{ticket}/notes', [SupportController::class, 'storeNote'])->name('support.notes.store');
        Route::delete('/support/{ticket}/notes/{note}', [SupportController::class, 'destroyNote'])->name('support.notes.destroy');
    });

    // ── Admin ── (permission: view admin / manage users)
    // solo administrator
    Route::middleware('permission:view admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    Route::middleware('permission:manage users')->group(function () {
        Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
        // permissions debe ir antes de {user} para evitar conflicto de rutas
        Route::put('/admin/permissions', [AdminController::class, 'updatePermissions'])->name('admin.permissions.update');
        Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::post('/admin/{user}/convert-prospect', [AdminController::class, 'convertToProspect'])->name('admin.convert.prospect');
    });

    // ── Profile ── (todos los roles)
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

Route::fallback(function () {
    return view('pages.404');
});