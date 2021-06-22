<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\Api\AFeedbackController;
use App\Http\Controllers\Api\ACandidateController;
use App\Http\Controllers\API\CountryAPIController;
use App\Http\Controllers\Api\ARecruitersController;
use App\Http\Controllers\Api\UserAccountController;
use App\Http\Controllers\Api\RecruiterJobController;
use App\Http\Controllers\Api\PermissionApiController;
use App\Http\Controllers\Api\CandidateResumeController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;

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

Route::post('v1/verifyemailphone', [UserAccountController::class, 'verifyemailphone']);
Route::post('v1/registerRecruiter', [UserAccountController::class, 'registerafterotp']);
Route::post('v1/registerCandidate', [UserAccountController::class, 'registerafterotpcandidate']);

Route::group(['prefix' => 'v1','middleware' => ['auth:api']], function () {

    Route::group(['prefix' => 'admin'], function () {
        // account info api for admin
        Route::get('admin-account-settings', [UserAccountController::class, 'showAdminAccountSettings']);
        Route::post('changeAdminPassword', [UserAccountController::class, 'changeAdminPassword']);
        Route::post('changeAdminInfo', [UserAccountController::class, 'changeAdminInfo']);

        Route::get('/recruiters', [ARecruitersController::class, 'index']);
        Route::post('/recruiters/view/{id}', [ARecruitersController::class, 'view']);
        Route::post('/recruiters/delete', [ARecruitersController::class, 'delete']);
        Route::post('/update-recruiters-account', [ARecruitersController::class, 'updateAccount']);
        Route::post('/update-recruiters-company', [ARecruitersController::class, 'updateCompany']);
        Route::post('/recruiters/disable', [ARecruitersController::class, 'disable']);
        Route::post('/recruiters/enable', [ARecruitersController::class, 'enable']);
        Route::post('recruiters/attachments', [UserAccountController::class, 'attachmentListById']);
        Route::post('recruiters/attachments/upload', [UserAccountController::class, 'uploadAttById']);
        Route::post('recruiters/attachments/delete', [UserAccountController::class, 'attachmentDeleteById']);

        Route::get('/candidates', [ACandidateController::class, 'index']);
        Route::post('/candidates/view/{id}', [ACandidateController::class, 'view']);
        Route::post('/candidates/delete', [ACandidateController::class, 'delete']);
        Route::post('/update-candidate-account', [ACandidateController::class, 'update']);
        Route::post('/candidates/enable', [ACandidateController::class, 'enable']);
        Route::post('/candidates/disable', [ACandidateController::class, 'disable']);

        Route::get('/feedback', [AFeedbackController::class, 'userFeedbacks']);
        Route::post('/feedback/delete', [AFeedbackController::class, 'delete']);
    });

    Route::group(['prefix' => 'recruiter'], function () {
        // account info api for recruiter
        Route::get('recruiter-account-settings', [UserAccountController::class, 'showRecruiterAccountSettings']);
        Route::post('/changeRecruiterPassword', [UserAccountController::class, 'changeRecruiterPassword']);
        Route::post('changeRecruiterInfo', [UserAccountController::class, 'changeRecruiterInfo']);

        Route::post('attachments', [UserAccountController::class, 'attachmentList']);
        Route::post('attachments/upload', [UserAccountController::class, 'uploadAtt']);
        Route::post('attachments/delete', [UserAccountController::class, 'attachmentDelete']);

        Route::get('list-jobs', [RecruiterJobController::class, 'index']);
        Route::post('/jobs/create-job', [RecruiterJobController::class, 'createJob']);
        Route::get('/job/view/{id}' , [RecruiterJobController::class, 'view']);
        Route::post('/jobs/enable', [RecruiterJobController::class, 'enable']);
        Route::post('/jobs/disable', [RecruiterJobController::class, 'disable']);
        Route::post('/jobs/delete', [RecruiterJobController::class, 'delete']);
        Route::get('/jobs/edit', [RecruiterJobController::class, 'editJob']);
        Route::post('/jobs/update', [RecruiterJobController::class, 'updateJob']);

        Route::post('/feedback', [RecruiterJobController::class, 'submitFeedback']);
    });

    Route::group(['prefix' => 'candidate'], function () {
        // account info api for candidate
        Route::get('candidate-account-settings', [UserAccountController::class, 'showCandidateAccountSettings']);
        Route::post('changeCandidatePassword', [UserAccountController::class, 'changeCandidatePassword']);
        Route::post('changeCandidateInfo', [UserAccountController::class, 'changeCandidateInfo']);

        Route::post('/candidate-resume-update', [CandidateResumeController::class, 'update']);
    });

});

Route::group(['prefix' => 'v1','middleware' => ['auth:web']], function () {

    Route::group(['prefix' => 'admin'], function () {
        // account info api for admin
        Route::get('admin-account-settings', [UserAccountController::class, 'showAdminAccountSettings']);
        Route::post('changeAdminPassword', [UserAccountController::class, 'changeAdminPassword']);
        Route::post('changeAdminInfo', [UserAccountController::class, 'changeAdminInfo']);

        Route::get('/recruiters', [ARecruitersController::class, 'index']);
        Route::post('/recruiters/view/{id}', [ARecruitersController::class, 'view']);
        Route::post('/recruiters/delete', [ARecruitersController::class, 'delete']);
        Route::post('/update-recruiters-account', [ARecruitersController::class, 'updateAccount']);
        Route::post('/update-recruiters-company', [ARecruitersController::class, 'updateCompany']);
        Route::post('/recruiters/disable', [ARecruitersController::class, 'disable']);
        Route::post('/recruiters/enable', [ARecruitersController::class, 'enable']);
        Route::post('recruiters/attachments', [UserAccountController::class, 'attachmentListById']);
        Route::post('recruiters/attachments/upload', [UserAccountController::class, 'uploadAttById']);
        Route::post('recruiters/attachments/delete', [UserAccountController::class, 'attachmentDeleteById']);

        Route::get('/candidates', [ACandidateController::class, 'index']);
        Route::post('/candidates/view/{id}', [ACandidateController::class, 'view']);
        Route::post('/candidates/delete', [ACandidateController::class, 'delete']);
        Route::post('/update-candidate-account', [ACandidateController::class, 'update']);
        Route::post('/candidates/enable', [ACandidateController::class, 'enable']);
        Route::post('/candidates/disable', [ACandidateController::class, 'disable']);

        Route::get('/feedback', [AFeedbackController::class, 'userFeedbacks']);
        Route::post('/feedback/delete', [AFeedbackController::class, 'delete']);
    });

    Route::group(['prefix' => 'recruiter'], function () {
        // account info api for recruiter
        Route::get('recruiter-account-settings', [UserAccountController::class, 'showRecruiterAccountSettings']);
        Route::post('/changeRecruiterPassword', [UserAccountController::class, 'changeRecruiterPassword']);
        Route::post('changeRecruiterInfo', [UserAccountController::class, 'changeRecruiterInfo']);

        Route::post('attachments', [UserAccountController::class, 'attachmentList']);
        Route::post('attachments/upload', [UserAccountController::class, 'uploadAtt']);
        Route::post('attachments/delete', [UserAccountController::class, 'attachmentDelete']);

        Route::get('list-jobs', [RecruiterJobController::class, 'index']);
        Route::post('/jobs/create-job', [RecruiterJobController::class, 'createJob']);
        Route::get('/job/view/{id}' , [RecruiterJobController::class, 'view']);
        Route::post('/jobs/enable', [RecruiterJobController::class, 'enable']);
        Route::post('/jobs/disable', [RecruiterJobController::class, 'disable']);
        Route::post('/jobs/delete', [RecruiterJobController::class, 'delete']);
        Route::get('/jobs/edit', [RecruiterJobController::class, 'editJob']);
        Route::post('/jobs/update', [RecruiterJobController::class, 'updateJob']);

        Route::post('/feedback', [RecruiterJobController::class, 'submitFeedback']);
    });

    Route::group(['prefix' => 'candidate'], function () {
        // account info api for candidate
        Route::get('candidate-account-settings', [UserAccountController::class, 'showCandidateAccountSettings']);
        Route::post('changeCandidatePassword', [UserAccountController::class, 'changeCandidatePassword']);
        Route::post('changeCandidateInfo', [UserAccountController::class, 'changeCandidateInfo']);

        Route::post('/candidate-resume-update', [CandidateResumeController::class, 'update']);
    });

});

Route::group(['prefix' => 'v1','middleware' => ['auth']], function () {

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
