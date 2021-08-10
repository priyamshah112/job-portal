<?php

use App\Http\Controllers\Api\AppliedJobApiController;
use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CountryApiController;
use App\Http\Controllers\Api\CityApiController;
use App\Http\Controllers\Api\StateApiController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\FeedbackApiController;
use App\Http\Controllers\Api\CandidateApiController;
use App\Http\Controllers\Api\RecruitersApiController;
use App\Http\Controllers\Api\UserAccountController;
use App\Http\Controllers\Api\CandidateResumeController;
use App\Http\Controllers\Api\DepartmentApiController;
use App\Http\Controllers\Api\IndustrySegmentApiController;
use App\Http\Controllers\Api\JobFairApiController;
use App\Http\Controllers\Api\JobFairPaymentApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\PositionApiController;
use App\Http\Controllers\Api\QualificationApiController;
use App\Http\Controllers\Api\SkillApiController;
use App\Http\Controllers\Api\VideoResumeController;

Route::group(['prefix' => 'v1'], function () {

    Route::post('/login', [AuthApiController::class, 'login']);
    Route::post('verifyemailphone', [UserAccountController::class, 'verifyemailphone']);
    Route::post('registerRecruiter', [UserAccountController::class, 'registerafterotp']);
    Route::post('registerCandidate', [UserAccountController::class, 'registerafterotpcandidate']);

    Route::get('qualifications', [QualificationApiController::class,'index']);
    Route::get('departments', [DepartmentApiController::class,'index']);
    Route::get('skills', [SkillApiController::class,'index']);
    Route::get('industry_segments', [IndustrySegmentApiController::class,'index']);
    Route::get('positions', [PositionApiController::class,'index']);
    Route::get('countries', [CountryApiController::class, 'index']);
    Route::get('states/{id}', [StateApiController::class, 'countryBy']);
    Route::get('cities/{id}', [CityApiController::class, 'stateBy']);

    
    Route::group(['middleware' => ['auth:web']], function () {        
        
        Route::get('jobs', [JobApiController::class, 'index']);
        
        Route::get('/notifications', [NotificationApiController::class, 'index']);
        Route::get('/notifications/unread-count', [NotificationApiController::class, 'unread_notification_count']);
        Route::put('/notifications/mark-all-unread-to-read', [NotificationApiController::class, 'mark_all_unread_to_read']);
        Route::put('/notifications/{id}', [NotificationApiController::class, 'mark_read']);

        Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function () {
            // account info api for admin
            Route::get('admin-account-settings', [UserAccountController::class, 'showAdminAccountSettings']);
            Route::post('changeAdminPassword', [UserAccountController::class, 'changeAdminPassword']);
            Route::post('changeAdminInfo', [UserAccountController::class, 'changeAdminInfo']);
    
            Route::get('payments', [PaymentApiController::class, 'index']);
            
            Route::get('/recruiters', [RecruitersApiController::class, 'index']);
            Route::post('/recruiters/view/{id}', [RecruitersApiController::class, 'view']);
            Route::post('/recruiters/delete', [RecruitersApiController::class, 'delete']);
            Route::post('/update-recruiters-account', [RecruitersApiController::class, 'updateAccount']);
            Route::post('/update-recruiters-company', [RecruitersApiController::class, 'updateCompany']);
            Route::post('/recruiters/disable', [RecruitersApiController::class, 'disable']);
            Route::post('/recruiters/enable', [RecruitersApiController::class, 'enable']);
            Route::post('recruiters/attachments', [UserAccountController::class, 'attachmentListById']);
            Route::post('recruiters/attachments/upload', [UserAccountController::class, 'uploadAttById']);
            Route::post('recruiters/attachments/delete', [UserAccountController::class, 'attachmentDeleteById']);
    
            Route::get('/candidates', [CandidateApiController::class, 'index']);
            Route::post('/candidates/view/{id}', [CandidateApiController::class, 'view']);
            Route::post('/candidates/delete', [CandidateApiController::class, 'delete']);
            Route::post('/update-candidate-account', [CandidateApiController::class, 'update']);
            Route::post('/candidates/enable', [CandidateApiController::class, 'enable']);
            Route::post('/candidates/disable', [CandidateApiController::class, 'disable']);
    
            Route::get('/feedback', [FeedbackApiController::class, 'userFeedbacks']);
            Route::post('/feedback/delete', [FeedbackApiController::class, 'delete']);
        
            Route::post('/jobs/satus/{id}', [JobApiController::class, 'satus']);

            Route::group(['prefix' => 'job-fair'], function () {

                Route::get('/show/{id}', [JobFairApiController::class, 'show']);
                Route::post('/create', [JobFairApiController::class, 'store']);
                Route::post('/details-update/{id}', [JobFairApiController::class, 'jobFairDetailsUpdate']);
                Route::post('/contact-update/{id}', [JobFairApiController::class, 'jobFairContactUpdate']);
                Route::post('/event-date-time-update/{id}', [JobFairApiController::class, 'jobFairEventDateTimeUpdate']);
                Route::delete('/delete/{id}', [JobFairApiController::class, 'destroy']);
                Route::get('/{id}/payments', [JobFairPaymentApiController::class, 'show']);

            });
        });
    
        Route::group(['prefix' => 'recruiter', 'middleware' => 'role:recruiter'], function () {
            
            // account info api for recruiter
            Route::get('recruiter-account-settings', [UserAccountController::class, 'showRecruiterAccountSettings']);
            Route::post('/changeRecruiterPassword', [UserAccountController::class, 'changeRecruiterPassword']);
            Route::post('changeRecruiterInfo', [UserAccountController::class, 'changeRecruiterInfo']);
            
            Route::post('attachments', [UserAccountController::class, 'attachmentList']);
            Route::post('attachments/upload', [UserAccountController::class, 'uploadAtt']);
            Route::post('attachments/delete', [UserAccountController::class, 'attachmentDelete']);
            
            Route::get('/candidates', [CandidateApiController::class, 'index']);
            
            //Payment
            Route::post('order/{id}', [PaymentApiController::class, 'order']);
            Route::post('payments', [PaymentApiController::class, 'store']);
            
            Route::post('/jobs/create-job', [JobApiController::class, 'store']);
            Route::post('/jobs/job-detail-update/{id}', [JobApiController::class, 'jobDetailUpdate']);
            Route::post('/jobs/criteria-update/{id}', [JobApiController::class, 'jobCriteriaUpdate']);
            Route::post('/jobs/location-update/{id}', [JobApiController::class, 'jobLocationUpdate']);
            
            Route::get('/job/view/{id}' , [JobApiController::class, 'view']);
            Route::post('/jobs/enable', [JobApiController::class, 'enable']);
            Route::post('/jobs/disable', [JobApiController::class, 'disable']);
            Route::post('/jobs/delete', [JobApiController::class, 'destroy']);
            Route::get('/jobs/edit', [JobApiController::class, 'edit']);
            Route::post('/jobs/update', [JobApiController::class, 'update']);  
            
            Route::get('/job/participate/{job_fair_id}', [JobApiController::class, 'participate']);

            Route::group(['prefix' => 'job-fair'], function () {
                Route::post('/order/{id}', [JobFairPaymentApiController::class, 'order']);
                Route::post('payments', [JobFairPaymentApiController::class, 'store']);
                Route::get('/{id}/jobs',[JobFairApiController::class, 'jobs']);
                Route::get('/{id}/applied-candidates',[JobFairApiController::class, 'appliedCandidates']);

            });

            Route::put('apllied-jobs/status/{id}', [AppliedJobApiController::class,'status']);

            Route::post('/feedback', [FeedbackApiController::class, 'store']);
        });
    
        Route::group(['prefix' => 'candidate', 'middleware' => 'role:candidate'], function () {
            // account info api for candidate
            Route::get('candidate-account-settings', [UserAccountController::class, 'showCandidateAccountSettings']);
            Route::post('changeCandidatePassword', [UserAccountController::class, 'changeCandidatePassword']);
            Route::post('changeCandidateInfo', [UserAccountController::class, 'changeCandidateInfo']);    
            Route::post('/personal-info-update', [CandidateResumeController::class, 'personalInfoUpdate']);
            Route::post('/address-update', [CandidateResumeController::class, 'addressUpdate']);
            Route::post('/contact-update', [CandidateResumeController::class, 'contactUpdate']);
            Route::post('/qualification-update', [CandidateResumeController::class, 'qualificationUpdate']);
            Route::delete('/video-resume-delete', [VideoResumeController::class, 'destroy']);

            Route::post('/job-apply/{id}', [AppliedJobApiController::class, 'store'])->name('job-apply');
            Route::get('/applied-jobs', [AppliedJobApiController::class, 'index'])->name('applied-jobs');

            Route::group(['prefix' => 'job-fair'], function () {
                Route::post('/apply/{id}', [JobFairApiController::class, 'apply'])->name('job-fair-apply');
            });

            Route::post('/feedback', [FeedbackApiController::class, 'store']);
        });  
          
    });

    Route::group(['prefix' => 'app','middleware' => ['auth:sanctum']], function () {        
        
        Route::get('jobs', [JobApiController::class, 'index']);
        
        Route::get('/notifications', [NotificationApiController::class, 'index']);
        Route::put('/notifications/mark-all-unread-to-read', [NotificationApiController::class, 'mark_all_unread_to_read']);
        Route::get('/notifications/unread-count', [NotificationApiController::class, 'unread_notification_count']);
        Route::put('/notifications/{id}', [NotificationApiController::class, 'mark_read']);
    
        Route::group(['prefix' => 'candidate', 'middleware' => 'role:candidate'], function () {
            // account info api for candidate
            Route::get('candidate-account-settings', [UserAccountController::class, 'showCandidateAccountSettings']);
            Route::post('changeCandidatePassword', [UserAccountController::class, 'changeCandidatePassword']);
            Route::post('changeCandidateInfo', [UserAccountController::class, 'changeCandidateInfo']);    
            Route::post('/personal-info-update', [CandidateResumeController::class, 'personalInfoUpdate']);
            Route::post('/address-update', [CandidateResumeController::class, 'addressUpdate']);
            Route::post('/contact-update', [CandidateResumeController::class, 'contactUpdate']);
            Route::post('/qualification-update', [CandidateResumeController::class, 'qualificationUpdate']);
            Route::post('/video-resume', [VideoResumeController::class, 'store']);
            Route::delete('/video-resume-delete', [VideoResumeController::class, 'destroy']);

            Route::post('/job-apply/{id}', [AppliedJobApiController::class, 'store'])->name('job-apply');
            Route::get('/applied-jobs', [AppliedJobApiController::class, 'index'])->name('applied-jobs');

            Route::group(['prefix' => 'job-fair'], function () {
                Route::post('/apply/{id}', [JobFairApiController::class, 'apply'])->name('job-fair-apply');
            });

            Route::post('/feedback', [FeedbackApiController::class, 'store']);
        });  
          
    });

});