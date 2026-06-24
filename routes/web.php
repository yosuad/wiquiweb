<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/public.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';

Route::fallback(function () {
    abort(404);
});