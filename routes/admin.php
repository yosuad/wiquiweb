<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactNoteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'approved'])->group(function () {

    // ── Dashboard ──
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/dashboard/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.settings.update');

    // ── Prospects ──
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

    // ── Contact Notes ──
    Route::middleware('permission:view prospects')->group(function () {
        Route::get('/prospects/{contact}/notes', [ContactNoteController::class, 'index'])->name('prospects.notes.index');
        Route::post('/prospects/{contact}/notes', [ContactNoteController::class, 'store'])->name('prospects.notes.store');
        Route::put('/prospects/{contact}/notes/{note}', [ContactNoteController::class, 'update'])->name('prospects.notes.update');
        Route::delete('/prospects/{contact}/notes/{note}', [ContactNoteController::class, 'destroy'])->name('prospects.notes.destroy');
    });

    // ── Customers ──
    Route::middleware('permission:view customers')->group(function () {
        Route::get('/customers', [ContactController::class, 'customers'])->name('customers');
        Route::get('/customers/{contact}', [ContactController::class, 'show'])->name('customers.show');
    });

    Route::middleware('permission:edit customers')->group(function () {
        Route::get('/customers/{contact}/edit', [ContactController::class, 'customerEdit'])->name('customers.edit');
        Route::put('/customers/{contact}', [ContactController::class, 'customerUpdate'])->name('customers.update');
        Route::patch('/customers/service/{contactService}/status', [ContactController::class, 'updateServiceStatus'])->name('customers.service.status');
        Route::patch('/customers/service/{contactService}/description', [ContactController::class, 'updateServiceDescription'])->name('customers.service.description');
        Route::put('/billing/{invoice}', [BillingController::class, 'update'])->name('billing.update');
    });

    Route::middleware('permission:delete customers')->group(function () {
        Route::delete('/customers/{contact}', [ContactController::class, 'destroy'])->name('customers.destroy');
    });

    // ── Billing ──
    Route::middleware('permission:view billing')->group(function () {
        Route::get('/billing', [BillingController::class, 'index'])->name('billing');
        Route::get('/billing/{contact}/invoices', [BillingController::class, 'show'])->name('billing.show');
        Route::get('/billing/{invoice}/invoice', [BillingController::class, 'invoice'])->name('billing.invoice');
    });

    Route::middleware('permission:edit billing')->group(function () {
        Route::delete('/billing/{invoice}', [BillingController::class, 'destroy'])->name('billing.destroy');
    });

    // ── Services + Subscribers ── (solo administrator)
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

        Route::get('/subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
        Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
        Route::delete('/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    });

    // ── Support ──
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

    // ── Admin ──
    Route::middleware('permission:view admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    Route::middleware('permission:manage users')->group(function () {
        Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
        Route::put('/admin/permissions', [AdminController::class, 'updatePermissions'])->name('admin.permissions.update');
        Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::post('/admin/{user}/convert-prospect', [AdminController::class, 'convertToProspect'])->name('admin.convert.prospect');
    });

    // ── Blog ── (admin en /admin/blog para no chocar con el blog público en /blog)
    Route::prefix('admin/blog')->name('blog.')->group(function () {

        Route::middleware('permission:view blog')->group(function () {
            Route::get('/', [BlogPostController::class, 'index'])->name('index');
        });

        Route::middleware('permission:create blog')->group(function () {
            Route::get('/create', [BlogPostController::class, 'create'])->name('create');
            Route::post('/', [BlogPostController::class, 'store'])->name('store');
            Route::post('/content-image', [BlogPostController::class, 'uploadContentImage'])->name('content-image');
        });

        // Categorías: van antes de /{post} para que "categories" no se tome como un post
        Route::middleware('permission:edit blog')->group(function () {
            Route::get('/categories', [BlogCategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [BlogCategoryController::class, 'store'])->name('categories.store');
            Route::patch('/categories/{category}', [BlogCategoryController::class, 'update'])->name('categories.update');
            Route::patch('/categories/{category}/default', [BlogCategoryController::class, 'setDefault'])->name('categories.default');
        });

        Route::middleware('permission:delete blog')->group(function () {
            Route::delete('/categories/{category}', [BlogCategoryController::class, 'destroy'])->name('categories.destroy');
        });

        Route::middleware('permission:edit blog')->group(function () {
            Route::get('/{post}/edit', [BlogPostController::class, 'edit'])->name('edit');
            Route::put('/{post}', [BlogPostController::class, 'update'])->name('update');
        });

        Route::middleware('permission:delete blog')->group(function () {
            Route::delete('/{post}', [BlogPostController::class, 'destroy'])->name('destroy');
        });
    });

    // ── Profile ──
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
