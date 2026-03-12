<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Commands
|--------------------------------------------------------------------------
*/

// Display an inspiring quote in the console
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
*/

// Generate monthly invoices automatically on the 1st of each month at 8:00 AM
// Run manually: php artisan invoices:generate-monthly
Schedule::command('invoices:generate-monthly')->monthlyOn(1, '08:00');