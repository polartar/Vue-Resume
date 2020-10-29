<?php

use App\Http\Controllers\UpdateUserController;
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

Route::middleware(['auth:sanctum'])->get('/', function () {
    $resumes = \Illuminate\Support\Facades\Auth::user()->resumes()->get();
    return view('pages.home', compact('resumes'));
})->name('home');

Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('logout', 'App\Http\Controllers\AccountController@logout')->name('account.logout');

Route::middleware(['auth:sanctum'])->get('/resume-builder/{any?}', 'App\Http\Controllers\SpaController@index')->where('any', '.*')->name('resume-builder');

Route::middleware(['auth:sanctum'])->get('/new-resume', 'App\Http\Controllers\ResumeController@create')->name('new-resume');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('resume', \App\Http\Controllers\ResumeController::class);
    Route::resource('resume-summary', \App\Http\Controllers\ResumeSummaryController::class);
    Route::resource('resume-description', \App\Http\Controllers\ResumeDescriptionController::class);

    Route::resource('user-phone', \App\Http\Controllers\UserPhoneController::class);
    Route::resource('user-email', \App\Http\Controllers\UserEmailController::class);
    Route::resource('user-address', \App\Http\Controllers\UserAddressController::class);
    Route::put('/update-user/{user}', \App\Http\Controllers\UpdateUserController::class);
    
    Route::resource('resume-work-experience', \App\Http\Controllers\ResumeWorkExperienceController::class);
    Route::put('/resume-work-experiences', \App\Http\Controllers\UpdateResumeWorkExperiencesOrderController::class);
    
    Route::resource('resume-education', \App\Http\Controllers\ResumeEducationController::class);
    Route::put('/resume-educations', \App\Http\Controllers\UpdateResumeEducationsOrderController::class);

    Route::resource('resume-design', \App\Http\Controllers\ResumeDesignController::class);
    Route::resource('education-description', \App\Http\Controllers\EducationDescriptionController::class);
    Route::resource('hobby', \App\Http\Controllers\HobbiesController::class);
    
    Route::get('/generate-resume-pdf/{resume}', \App\Http\Controllers\GenerateResumePdfController::class);
});
