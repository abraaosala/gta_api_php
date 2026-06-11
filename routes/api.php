<?php

use App\Http\Controllers\Api\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Api\Admin\BusinessInfoController as AdminBusinessInfoController;
use App\Http\Controllers\Api\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Api\Admin\EstimatorDeviceController as AdminEstimatorDeviceController;
use App\Http\Controllers\Api\Admin\EstimatorIssueController as AdminEstimatorIssueController;
use App\Http\Controllers\Api\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Api\Admin\FeatureController as AdminFeatureController;
use App\Http\Controllers\Api\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Api\Admin\ProcessStepController as AdminProcessStepController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Api\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Api\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Public\ContactController;
use App\Http\Controllers\Api\Public\LandingController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): array {
    return [
        'message' => 'GTA Tech API',
        'version' => '1.0.0',
    ];
});

// Auth
Route::post('/auth/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Admin
    Route::prefix('admin')->group(function () {
        Route::get('users', [AdminUserController::class, 'index']);
        Route::post('users', [AdminUserController::class, 'store']);
        Route::get('users/me', [AdminUserController::class, 'me']);
        Route::put('users/me/password', [AdminUserController::class, 'updatePassword']);
        Route::get('users/{user}', [AdminUserController::class, 'show']);
        Route::put('users/{user}', [AdminUserController::class, 'update']);
        Route::delete('users/{user}', [AdminUserController::class, 'destroy']);

        Route::post('upload', [UploadController::class, 'store']);

        Route::apiResource('services', AdminServiceController::class);
        Route::apiResource('products', AdminProductController::class);
        Route::apiResource('testimonials', AdminTestimonialController::class);
        Route::apiResource('faqs', AdminFaqController::class);
        Route::apiResource('brands', AdminBrandController::class);
        Route::apiResource('process', AdminProcessStepController::class);
        Route::apiResource('features', AdminFeatureController::class);
        Route::apiResource('gallery', AdminGalleryController::class);
        Route::apiResource('team', AdminTeamController::class);
        Route::apiResource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);
        Route::apiResource('estimator/devices', AdminEstimatorDeviceController::class);
        Route::apiResource('estimator/issues', AdminEstimatorIssueController::class);

        Route::get('info', [AdminBusinessInfoController::class, 'show']);
        Route::put('info', [AdminBusinessInfoController::class, 'update']);

        Route::get('settings', [AdminSettingsController::class, 'index']);
        Route::put('settings', [AdminSettingsController::class, 'update']);
    });
});

// Public
Route::prefix('public')->group(function () {
    Route::get('landing', LandingController::class);
    Route::post('contacts', [ContactController::class, 'store']);
});
