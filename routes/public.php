<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

// ===== Páginas públicas =====
Route::get('/', [PageController::class, 'start'])->middleware('guest')->name('home');
Route::get('/nosotros', [PageController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
Route::get('/portafolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/privacy_policy', [PageController::class, 'privacy'])->name('privacy');

// ===== Servicios =====

Route::get('/servicios/correos-corporativos', [PageController::class, 'emails'])->name('services.emails');
Route::get('/servicios/diseno', [PageController::class, 'design'])->name('services.design');
Route::get('/servicios/consultoria-digital', [PageController::class, 'consulting'])->name('services.consulting');
Route::get('/servicios/diseno-web', [PageController::class, 'webDesign'])->name('services.web-design');
Route::get('/servicios/landing-page', [PageController::class, 'landing'])->name('services.landing');

Route::get('/portafolio/yosuad', [PageController::class, 'yosuad'])->name('portfolio.yosuad');



// ===== Leads =====
Route::get('/form', [PageController::class, 'form'])->middleware('guest')->name('form');
Route::post('/contacto', [ContactController::class, 'formstartstore'])->name('leads.store');
Route::post('/form', [ContactController::class, 'leadStore'])->name('leads.meta.store');

// ===== Suscriptores =====
Route::post('/suscribirse', [SubscriberController::class, 'store'])->name('subscribers.store');
Route::get('/unsubscribe', [SubscriberController::class, 'unsubscribePage'])->name('subscribers.unsubscribe.page');
Route::post('/unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('subscribers.unsubscribe');