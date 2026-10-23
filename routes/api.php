<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| NutriDesk RESTful API Routes (For Mobile Apps & Web Client)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public Catalog & General Endpoints
    Route::get('/packages', [CatalogController::class, 'packages']);
    Route::get('/packages/{code}', [CatalogController::class, 'packageDetail']);
    Route::get('/fruits', [CatalogController::class, 'fruits']);
    Route::get('/dietitian-plan', [CatalogController::class, 'dietitianWeeklyMenu']);

    // Authentication
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected Routes (Customer Sanctum Token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Subscriptions & Daily Deliveries
        Route::get('/subscriptions', [SubscriptionController::class, 'index']);
        Route::post('/subscriptions', [SubscriptionController::class, 'store']);
        Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show']);
        Route::post('/subscriptions/{id}/pause-day', [SubscriptionController::class, 'pauseDay']);
        Route::post('/subscriptions/{id}/resume-day', [SubscriptionController::class, 'resumeDay']);

        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
    });
});
