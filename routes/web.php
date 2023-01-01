<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\MedicalFieldController;
use App\Http\Controllers\MedicalSubFieldController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BoardingController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DoctorsPositionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm']);
Route::get('/login/doctor', [LoginController::class, 'showDoctorLoginForm']);
Route::get('/register/admin', [RegisterController::class, 'showAdminRegisterForm']);
Route::get('/register/doctor', [RegisterController::class, 'showDoctorRegisterForm']);

Route::post('/login/admin',[LoginController::class, 'adminLogin']);
Route::post('/login/doctor', [LoginController::class, 'doctorLogin']);
Route::post('/register/admin', [RegisterController::class, 'createAdmin']);
Route::post('/register/doctor', [RegisterController::class, 'createDoctor']);

Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin');
Route::view('/doctor', 'doctor');

//admin route
//$this->middleware(['auth:admin','auth']);
Route::group([ 'prefix' => 'admin'], function () {
 //medicine-fields
 Route::resource('medicine-fields', MedicalFieldController::class);
 //medicine-sub-fields
 Route::resource('medicine-sub-fields', MedicalSubFieldController::class);
 //countries
 Route::resource('countries', CountryController::class);
 //cities
 Route::resource('cities', CityController::class);

 Route::resource('doctors', DoctorsController::class);

 Route::resource('clinics', ClinicController::class);
 Route::resource('patients', PatientController::class);
 //boarding
 Route::resource('boarding', BoardingController::class);
 Route::resource('position', DoctorsPositionController::class);
 Route::resource('faq', FaqController::class);
 //
 Route::resource('patients', PatientController::class);
 Route::get('/patients-favorite', [PatientController::class, 'favorite'])->name('patients-favorite');
 Route::get('/patients-review', [PatientController::class, 'review'])->name('patients-review');

 Route::get('/bdg-data', [FaqController::class, 'createForm'])->name('bdg-data');
Route::post('/bdg-data', [FaqController::class, 'DataForm'])->name('data.store');
Route::resource('all-admins', AdminController::class);
Route::get('/all-reservations', [ReservationController::class, 'allReservation'])->name('all-reservations');
Route::get('/complete-reservations', [ReservationController::class, 'completeReservation'])->name('complete-reservations');
Route::get('/cancelled-reservations', [ReservationController::class, 'cancelledReservation'])->name('cancelled-reservations');
Route::get('/show-all-reservation/{id}', [ReservationController::class, 'showAllReservation'])->name('show-all-reservation');
Route::get('/show-complete-reservation/{id}', [ReservationController::class, 'showCompleteReservation'])->name('show-complete-reservation');
Route::get('/show-cancelled-reservation/{id}', [ReservationController::class, 'showCancelledReservation'])->name('show-cancelled-reservation');

});
