<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\DoctorsInfController;
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

Route::middleware('auth:api')->group( function () {
    // Route::resource('products', ProductController::class);
    Route::post('make-review', [PatientController::class, 'review']);
    //favourite
    Route::post('favourite-doctors', [PatientController::class, 'favourite']);
    //reservation
    // Route::post('reservation', [PatientController::class, 'reservation']);
    Route::get('show-reservation', [PatientController::class, 'showRreservation']);
    Route::post('cancel-reservation', [PatientController::class, 'cancelReservation']);

});

Route::middleware("localization")->group(function () {

    Route::get('faq', [ContactController::class, 'getFaq']);

    Route::get('search-doc-category', [PatientController::class, 'search']);

    Route::get('home', [DoctorsInfController::class, 'doctorsInf']);
      //doc profile
      Route::get('/show-doc-profile/{id}', [DoctorsInfController::class, 'docProfile'])->name('show-doc-profile');


});

Route::group(['middleware' => ['localization', 'auth:api']], function() {
    Route::get('get-reservation', [PatientController::class, 'getReservation']);
    Route::post('reservation', [PatientController::class, 'reservation']);
    Route::post('update-patient', [RegisterController::class, 'updateUser']);
    Route::post('update-patient-image', [RegisterController::class, 'updateUserImage']);
    Route::get('favorite-doctors', [PatientController::class, 'favoriteDoctors']);



});
