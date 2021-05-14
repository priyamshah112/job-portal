<?php

use App\Http\Controllers\API\AdvertAPIController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\API\CategoriesAPIController;
use App\Http\Controllers\API\CountryAPIController;
use App\Http\Controllers\API\DocUserAPIController;
use App\Http\Controllers\API\HomeBannerAPIController;
use App\Http\Controllers\Api\PermissionApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\API\TestimonialsAPIController;
use App\Http\Controllers\API\UserAPIController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot', [ForgotPasswordController::class, 'forgotPassword']);

Route::group(['prefix' => 'v1'], function () {
    
    Route::resource('countries', CountryAPIController::class);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function (Request $request) {
        return auth()->user();
    });
    Route::group(['prefix' => 'auth'], function(){

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::post('/emailVerify', [AuthController::class, 'emailVerification']);

        Route::post('/otpVerify', [AuthController::class, 'emailVerificationOtp']);

        Route::post('/changePassword', [AuthController::class, 'changePassword']);

        Route::post('/forgotVerfiyOtp', [ForgotPasswordController::class, 'forgot_password_otpVerify']);

        Route::post('/forgotNewPassword', [ForgotPasswordController::class, 'forgotPasswordChange']);
        
    });
});

Route::group(['prefix' => 'v1','middleware' => ['auth:web']], function () {

    Route::get('/roles', [RoleAPIController::class, 'index']);
    Route::get('/frontEndRoles', [RoleAPIController::class, 'frontEndRoles']);
    Route::get('/roles/{id}', [RoleApiController::class, 'show']);
    Route::post('/roles', [RoleAPIController::class, 'store']);
    Route::put('/roles/{id}', [RoleAPIController::class, 'update']);
    Route::delete('/roles/{id}', [RoleAPIController::class, 'destroy']);

    Route::get('/permissions', [PermissionApiController::class, 'index']);
    Route::get('/permissions/{id}', [PermissionApiController::class, 'show']);
    Route::post('/permissions', [PermissionApiController::class, 'store']);
    Route::put('/permissions/{id}', [PermissionApiController::class, 'update']);
    Route::delete('/permissions/{id}', [PermissionApiController::class, 'destroy']);

    Route::get('/users', [UserAPIController::class, 'index']);
    Route::get('/users/{id}', [UserAPIController::class, 'show']);
    Route::post('/users', [UserAPIController::class, 'store']);
    Route::put('/users/{id}', [UserAPIController::class, 'update']);
    Route::delete('/users/{id}', [UserAPIController::class, 'destroy']);
    Route::post('/users/changeInfo',[UserAPIController::class, 'changeInfo']);
    Route::post('/users/changePassword',[UserAPIController::class, 'changePassword']);

});