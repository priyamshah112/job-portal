<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AJobFairController;
use App\Http\Controllers\Recruiter\RJobController;
use App\Http\Controllers\Admin\ADashboardController;
use App\Http\Controllers\Admin\ACandidatesController;
use App\Http\Controllers\Admin\ARecruitersController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Candidate\CResumeController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Candidate\CAllJobsController;
use App\Http\Controllers\Candidate\FeedbackController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Candidate\RCJobFairController;
use App\Http\Controllers\Recruiter\RDashboardController;
use App\Http\Controllers\Candidate\CAppliedJobsController;
use App\Http\Controllers\Recruiter\RAppliedCandidatesController;

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

// Main Page Route

// Admin
Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes();
    Route::group(['prefix' => 'admin'], function () {

        // Auth::routes(['verify' => true, 'register' => false]);
        Route::get('login', [LoginController::class, 'showLoginFormAdmin'])->name('loginAdmin')->middleware('guest');
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::group(['middleware' => ['role:admin']], function () {

            Route::get('/dashboard', [ADashboardController::class, 'adminDashboard'])->name('admin-dashboard');

            Route::get('/recruiters', [ARecruitersController::class, 'index'])->name('arecruiters');
            Route::get('/recruiters/{id}', [ARecruitersController::class, 'view'])->name('arecruiters-view');
            Route::get('/recruiters/edit/{id}', [ARecruitersController::class, 'edit'])->name('arecruiters-edit');
            Route::post('/recruiters/enable', [ARecruitersController::class, 'enable'])->name('enable-recruiter');
            // Route::post('/recruiters/disable', [ARecruitersController::class, 'disable'])->name('disable-recruiter');
            Route::post('/recruiters/delete', [ARecruitersController::class, 'delete'])->name('delete-recruiter');
            Route::post('update-recruiters/{id}', [ARecruitersController::class, 'update'])->name('arecruiters-update');

            Route::get('/candidates', [ACandidatesController::class, 'index'])->name('acandidates');
            Route::post('/candidates/enable', [ACandidatesController::class, 'enable'])->name('enable-candidate');
            Route::post('/candidates/disable', [ACandidatesController::class, 'disable'])->name('disable-candidate');
            Route::post('/candidates/delete', [ACandidatesController::class, 'delete'])->name('delete-candidate');
            Route::get('/candidates/{id}', [ACandidatesController::class, 'view'])->name('acandidates-view');
            Route::get('/candidates/edit/{id}', [ACandidatesController::class, 'edit'])->name('acandidates-edit');
            Route::post('/candidates/update/{id}', [ACandidatesController::class, 'update'])->name('acandidates-update');

            Route::get('account-settings', [UserController::class, 'showUserAccountSettings'])->name('user-account-settings');

            Route::get('create-job-fair', [AJobFairController::class, 'getCreateJobFairForm'])->name('create-job-fair');

            Route::get('list-job-fair', [AJobFairController::class, 'index'])->name('list-job-fair');

            Route::resource('users', UserController::class);

            Route::get('/feedback', [FeedbackController::class, 'userFeedbacks'])->name('feedback-admin');
            Route::post('/feedback/delete', [FeedbackController::class, 'delete'])->name('feedback-delete');

            // Account Setting
            Route::get('admin-account-settings', [UserController::class, 'showAdminAccountSettings'])->name('admin-account-settings');
//            Route::post('changeAdminPassword', [UserController::class, 'changeAdminPassword'])->name('changeAdminPassword');
//            Route::post('changeAdminInfo', [UserController::class, 'changeAdminInfo'])->name('changeAdminInfo');

        });
    });

// Recruiter

    Route::group(['prefix' => 'recruiter'], function () {
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('recruiter-register');
        Route::post('register', [RegisterController::class, 'create'])->name('register-recruiter');

        Route::group(['middleware' => ['active_user', 'role:recruiter']], function () {

            Route::get('/dashboard', [RDashboardController::class, 'rdashboardAnalytics'])->name('recruiter-dashboard');

            Route::get('/applied_candidates', [RAppliedCandidatesController::class, 'index'])->name('rappliedcandidates');

            Route::get('create-jobs', [RJobController::class, 'getCreateJobForm'])->name('recruiter-jobs-create');
            Route::get('list-jobs', [RJobController::class, 'index'])->name('list-jobs');
            Route::get('/feedback', [FeedbackController::class, 'recruiter'])->name('feedback-recruiter');
            Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback-recruiter-submit');
            Route::get('/jobs', [RJobController::class, 'index'])->name('recruiter-jobs');
            Route::post('/jobs', [RJobController::class, 'createJob'])->name('create-job-submit');
            Route::post('/jobs/enable', [RJobController::class, 'enable'])->name('enable-recruiter-job');
            Route::post('/jobs/disable', [RJobController::class, 'disable'])->name('disable-recruiter-job');
            Route::post('/jobs/delete', [RJobController::class, 'delete'])->name('delete-recruiter-job');
            Route::get('/jobs/edit/{id}', [RJobController::class, 'editJob'])->name('recruiter-jobs-edit');
            Route::post('update-job/{id}', [RJobController::class, 'updateJob'])->name('recruiter-jobs-update');
            Route::get('jobs/view/{id}', [RJobController::class, 'view'])->name('recruiter-jobs-view');
            Route::post('jobs/fetch-city', [RJobController::class, 'fetchCities'])->name('recruiter-jobs-city');
            // Admin Account Setting
            Route::get('recruiter-account-settings', [UserController::class, 'showRecruiterAccountSettings'])->name('recruiter-account-settings');
            Route::post('changeRecruiterPassword', [UserController::class, 'changeRecruiterPassword'])->name('changeRecruiterPassword');
            Route::post('/changeRecruiterInfo', [UserController::class, 'changeRecruiterInfo'])->name('changeRecruiterInfo');
        });
    });

// Candidate

    Route::group(['prefix' => 'candidate'], function () {

        Route::get('register', [RegisterController::class, 'candidateRegister'])->name('candidate-register');
        Route::post('register', [RegisterController::class, 'candidateCreate'])->name('register-candidate');
        Route::group(['middleware' => ['active_user', 'role:candidate']], function () {

            Route::get('/alljobs', [CAllJobsController::class, 'index'])->name('alljobs');

            Route::get('/appliedjobs', [CAppliedJobsController::class, 'index'])->name('cappliedjobs');

            Route::get('edit-resume', [CResumeController::class, 'edit'])->name('candidate-resume-edit');
//            Route::post('update-resume', [CResumeController::class, 'update'])->name('candidate-resume-update');

            Route::get('/list-resume', [CResumeController::class, 'index'])->name('candidate-resume');

            Route::get('/video-resume', [MediaController::class, 'index'])->name('candidate-video-resume');
            Route::post('/video-resume-store', [MediaController::class, 'store'])->name('candidate-video-resume-store');


            // feedback
            Route::get('/feedback', [FeedbackController::class, 'candidates'])->name('candidate-feedback');
            Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback-candidates-submit');

            // Recruiter Account Setting
            Route::get('candidate-account-settings', [UserController::class, 'showCandidateAccountSettings'])->name('candidate-account-settings');
            Route::post('changeCandidatePassword', [UserController::class, 'changeCandidatePassword'])->name('changeCandidatePassword');
            Route::post('changeCandidateInfo', [UserController::class, 'changeCandidateInfo'])->name('changeCandidateInfo');
        });
    });

    Route::get('/pending-status', function () {
        return view('pending-status');
    });
    Route::get('/pending-approval', function () {
        return view('pending-approval');
    });
    Route::get('/account-blocked', function () {
        return view('account-blocked');
    });

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/welcome', function () {
        return view('welcome');
    });
    Route::get('/recruiter-register', [RCJobFairController::class, 'index'])->name('job_fair');
    Route::get('/job_fair', [RCJobFairController::class, 'index'])->name('job_fair_1');

// Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');

    Route::get('test', function () {
        return view('content.apps.user.app-user-edit');
    });

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); // v6.x
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});
