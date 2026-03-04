<?php

use App\Http\Controllers\InstallController;
use App\Http\Middleware\InstallMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(InstallMiddleware::class . ':install')
    ->prefix('install')
    ->name('install.')
    ->group(function () {

        // Step 1: Requirements
        Route::get('/', [InstallController::class, 'requirements'])->name('requirements');

        // Step 2: Permissions
        Route::get('/permissions', [InstallController::class, 'permissions'])->name('permissions');

        // Step 3: Database
        Route::get('/database', [InstallController::class, 'database'])->name('database');
        Route::post('/database', [InstallController::class, 'saveDatabase'])->name('database.save');

        // Step 4: Admin
        Route::get('/admin', [InstallController::class, 'admin'])->name('admin');
        Route::post('/admin', [InstallController::class, 'saveAdmin'])->name('admin.save');

        // Step 5: Settings
        Route::get('/settings', [InstallController::class, 'settings'])->name('settings');
        Route::post('/settings', [InstallController::class, 'saveSettings'])->name('settings.save');

        // Step 6: Run Installation
        Route::get('/run', [InstallController::class, 'run'])->name('run');
        Route::post('/execute', [InstallController::class, 'execute'])->name('execute');

        // Step 7: Complete
        Route::get('/complete', [InstallController::class, 'complete'])->name('complete');
    });
