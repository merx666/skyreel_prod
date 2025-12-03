<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('debug:log', function () {
    $context = [
        'ts' => now()->toDateTimeString(),
        'env' => app()->environment(),
        'cli' => PHP_SAPI === 'cli',
    ];

    Log::info('Debug artisan log hit', $context);

    $this->comment('Logged "Debug artisan log hit" to storage/logs/laravel.log');
})->purpose('Generate a test log entry in storage/logs/laravel.log');
