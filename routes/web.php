<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CandidatesController;
use App\Http\Controllers\Admin\RecruitersController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Candidate\ResumeController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\JobFairController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// For Guest Route

Route::view('/', 'welcome');
Route::view('/pending-status', 'pending-status');
Route::view('/pending-approval','pending-approval');
Route::view('/account-blocked', 'account-blocked');

Auth::routes(['verify' => true, 'register' => false]);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); // v6.x
Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['prefix' => 'recruiter'], function () {
   
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('recruiter-register');
    Route::post('register', [RegisterController::class, 'create'])->name('register-recruiter');

});

Route::group(['prefix' => 'candidate'], function () {

    Route::get('register', [RegisterController::class, 'candidateRegister'])->name('candidate-register');
    Route::post('register', [RegisterController::class, 'candidateCreate'])->name('register-candidate');

});

// For Auth Routes
Route::group(['middleware' => ['active_user','auth']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 

    Route::get('/jobs', [JobController::class, 'index'])->name('jobs');

    Route::get('/job-fair', [JobFairController::class, 'index'])->name('job-fairs');    
    
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedbacks');

    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback-store');

    // For Admin
    Route::group(['middleware' => 'role:admin'], function () {
        
        Route::get('/recruiters', [RecruitersController::class, 'index'])->name('recruiters');
        Route::get('/recruiters/{id}', [RecruitersController::class, 'show'])->name('recruiters-view');
        Route::get('/recruiters/edit/{id}', [RecruitersController::class, 'edit'])->name('recruiters-edit');
   
        Route::get('/candidates', [CandidatesController::class, 'index'])->name('candidates');
        Route::get('/candidates/{id}', [CandidatesController::class, 'show'])->name('candidates-view');
        Route::get('/candidates/edit/{id}', [CandidatesController::class, 'edit'])->name('candidates-edit');

        Route::get('job-fair/create', [JobFairController::class, 'createForm'])->name('job-fair-store');

        Route::group(['prefix' => 'admin'], function () {

            Route::get('account-settings', [UserController::class, 'showUserAccountSettings'])->name('user-account-settings');
            Route::resource('users', UserController::class);
            Route::get('admin-account-settings', [UserController::class, 'showAdminAccountSettings'])->name('admin-account-settings');
    
        });

    });

    // For Recruiters
    Route::group(['middleware' => 'role:recruiter'], function () {
        
        Route::get('jobs/create', [JobController::class, 'createForm'])->name('jobs-create');
        Route::get('jobs/view/{id}', [JobController::class, 'show'])->name('jobs-view');
        Route::get('jobs/edit/{id}', [JobController::class, 'edit'])->name('jobs-edit');   

        Route::get('applied-candidates', [JobController::class, 'appliedCandidates'])->name('applied-candidates');

        Route::group(['prefix' => 'recruiter'], function () {

            Route::get('recruiter-account-settings', [UserController::class, 'showRecruiterAccountSettings'])->name('recruiter-account-settings');
            Route::post('changeRecruiterPassword', [UserController::class, 'changeRecruiterPassword'])->name('changeRecruiterPassword');
            Route::post('/changeRecruiterInfo', [UserController::class, 'changeRecruiterInfo'])->name('changeRecruiterInfo');

        });

    });

    // For Candidates
    Route::group(['middleware' => 'role:candidate'], function () {  

        Route::get('applied-jobs', [JobController::class, 'appliedJobs'])->name('applied-jobs');
        Route::get('list-resume', [ResumeController::class, 'index'])->name('resume');
        Route::get('video-resume', [MediaController::class, 'index'])->name('video-resume');
        Route::get('edit-resume', [ResumeController::class, 'edit'])->name('candidate-resume-edit');
        Route::post('/video-resume-store', [MediaController::class, 'store'])->name('candidate-video-resume-store');

        Route::group(['prefix' => 'candidate'], function () {

            Route::get('candidate-account-settings', [UserController::class, 'showCandidateAccountSettings'])->name('candidate-account-settings');
            Route::post('changeCandidatePassword', [UserController::class, 'changeCandidatePassword'])->name('changeCandidatePassword');
            Route::post('changeCandidateInfo', [UserController::class, 'changeCandidateInfo'])->name('changeCandidateInfo');
        
        });
        
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
