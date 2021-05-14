<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ADashboardController;
use App\Http\Controllers\Admin\ARecruitersController;
use App\Http\Controllers\Admin\ACandidatesController;
use App\Http\Controllers\Admin\AJobFairController;

use App\Http\Controllers\Recruiter\RDashboardController;
use App\Http\Controllers\Recruiter\RAppliedCandidatesController;
use App\Http\Controllers\Recruiter\RJobController;

use App\Http\Controllers\Candidate\RCJobFairController;
use App\Http\Controllers\Candidate\FeedbackController;
use App\Http\Controllers\Candidate\CAllJobsController;
use App\Http\Controllers\Candidate\CAppliedJobsController;
use App\Http\Controllers\Candidate\CResumeController;
use App\Http\Controllers\Candidate\CVideoResumeController;

use App\Http\Controllers\Designs\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin'], function () {

    Auth::routes(['verify' => true, 'register' => false]);

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/dashboard', [ADashboardController::class, 'adashboardAnalytics'])->name('admin-dashboard');

        Route::get('/recruiters', [ARecruitersController::class, 'index'])->name('arecruiters');

        Route::get('/candidates', [ACandidatesController::class, 'index'])->name('acandidates');

        Route::get('account-settings', [UserController::class, 'showUserAccountSettings'])->name('user-account-settings');

        Route::get('create-job-fair', [AJobFairController::class, 'getCreateJobFairForm'])->name('create-job-fair');

        Route::get('list-job-fair', [AJobFairController::class, 'index'])->name('list-job-fair');

        Route::resource('users', UserController::class);

    });
});

// Recruiter

Route::group(['prefix' => 'recruiter'], function () {

    Auth::routes(['verify' => true, 'register' => false]);

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/dashboard', [RDashboardController::class, 'rdashboardAnalytics'])->name('recruiter-dashboard');

        Route::get('/applied_candidates', [RAppliedCandidatesController::class, 'index'])->name('rappliedcandidates');

        Route::get('account-settings', [UserController::class, 'showUserAccountSettings'])->name('user-account-settings');

        Route::get('create-jobs', [RJobController::class, 'getCreateJobForm'])->name('create-jobs');

        Route::get('list-jobs', [RJobController::class, 'index'])->name('list-jobs');

    });
});

// Candidate

Route::group(['prefix' => 'candidate'], function () {

    Auth::routes(['verify' => true, 'register' => false]);

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/alljobs', [CAllJobsController::class, 'index'])->name('alljobs');

        Route::get('/appliedjobs', [CAppliedJobsController::class, 'index'])->name('cappliedjobs');

        Route::get('account-settings', [UserController::class, 'showUserAccountSettings'])->name('user-account-settings');

        Route::get('create-resume', [CResumeController::class, 'getCreateResumeForm'])->name('create-resume');

        Route::get('list-resume', [CResumeController::class, 'index'])->name('list-resume');

        Route::get('/videoresume', [CVideoResumeController::class, 'index'])->name('cvideoresume');

    });
});

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/job_fair', [RCJobFairController::class, 'index'])->name('job_fair');

Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');        