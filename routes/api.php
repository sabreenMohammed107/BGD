<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\DoctorsInfController;
use App\Http\Controllers\Api\ForgotController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('forgot', [ForgotController::class, 'forgot']);
Route::post('reset', [ForgotController::class, 'reset']);
Route::get('/otp/send', [OtpController::class, 'sendOtp']);
//google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
//googleLogin
Route::get('googleLogin', [GoogleController::class, 'googleLogin']);

Route::middleware('auth:api')->group( function () {
    // Route::resource('products', ProductController::class);
    Route::post('make-review', [PatientController::class, 'review']);
    //favourite
    Route::post('mke-favourite-doctors', [PatientController::class, 'favourite']);
    //reservation
    // Route::post('reservation', [PatientController::class, 'reservation']);

    // Route::post('update-user', [AuthController::class, 'updateUser']);
    // Route::post('update-user-image', [AuthController::class, 'updateUserImage']);

    Route::post('token-update', [RegisterController::class, 'tokenUpdate']);
    Route::get('list-notifications', [RegisterController::class, 'allNofications']);
});

Route::middleware("localization")->group(function () {

    Route::get('faq', [ContactController::class, 'getFaq']);

});

Route::group(['middleware' => ['localization', 'auth:api']], function() {
    Route::get('get-reservation', [PatientController::class, 'getReservation']);

    Route::post('reservation', [PatientController::class, 'reservation']);
    Route::post('update-patient', [RegisterController::class, 'updateUser']);
    Route::post('update-patient-image', [RegisterController::class, 'updateUserImage']);
    Route::get('favorite-doctors', [PatientController::class, 'favoriteDoctors']);
    Route::post('remove-favourite-doctors', [PatientController::class, 'removeFavourite']);

    Route::get('search-doc-category', [PatientController::class, 'search']);
    Route::get('search-inputs', [PatientController::class, 'searchInputs']);
    Route::get('home', [DoctorsInfController::class, 'doctorsInf']);
    Route::get('show-new-reservation', [PatientController::class, 'showNewRreservation']);
    Route::get('show-old-reservation', [PatientController::class, 'showOldRreservation']);
    Route::post('cancel-reservation', [PatientController::class, 'cancelReservation']);
      //doc profile
      Route::get('/show-doc-profile/{id}', [DoctorsInfController::class, 'docProfile'])->name('show-doc-profile');




});
