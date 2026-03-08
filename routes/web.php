<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Module demo routes
Route::prefix('modules')->group(function () {
    Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/dashboard', [ModuleController::class, 'dashboard'])->name('modules.dashboard');
    Route::get('/analytics', [ModuleController::class, 'analytics'])->name('modules.analytics');
    Route::get('/settings', [ModuleController::class, 'settings'])->name('modules.settings');
    Route::get('/assets', [ModuleController::class, 'getAssets'])->name('modules.assets');
});

// API routes for demo
Route::prefix('api')->group(function () {
    Route::get('/dashboard/stats', function () {
        return response()->json([
            'users' => 1234,
            'sessions' => 89,
        ]);
    });

    Route::get('/analytics/data', function () {
        return response()->json([
            'pageviews' => 5678,
            'users' => 432,
        ]);
    });

    Route::get('/settings', function () {
        return response()->json([
            'app_name' => 'Laravel Modules Demo',
            'theme' => 'light',
            'notifications' => true,
            'language' => 'en',
        ]);
    });

    Route::post('/settings', function () {
        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully',
        ]);
    });

    Route::post('/analytics/events', function () {
        return response()->json([
            'success' => true,
            'message' => 'Events recorded',
        ]);
    });
});
