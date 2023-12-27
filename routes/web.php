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
use App\Http\Controllers\ClinicGalleryController;
use App\Http\Controllers\DoctorClinicController;
use App\Http\Controllers\DoctorClinicGalleryController;
use App\Http\Controllers\DoctorDataController;
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


Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/all-reservations', [ReservationController::class, 'allReservation'])->name('admin.all-reservations');
   //
   Route::get('/reservation-filter',[ReservationController::class, 'filter'])->name('admin.reservation-filter');
    Route::get('/complete-reservations', [ReservationController::class, 'completeReservation'])->name('admin.complete-reservations');
    Route::get('/cancelled-reservations', [ReservationController::class, 'cancelledReservation'])->name('admin.cancelled-reservations');
    Route::get('/cancelled-reservation-filter',[ReservationController::class, 'cancelledFilter'])->name('admin.cancelled-reservation-filter');

    Route::get('/show-all-reservation/{id}', [ReservationController::class, 'showAllReservation'])->name('admin.show-all-reservation');
    Route::get('/show-complete-reservation/{id}', [ReservationController::class, 'showCompleteReservation'])->name('admin.show-complete-reservation');
    Route::get('/show-cancelled-reservation/{id}', [ReservationController::class, 'showCancelledReservation'])->name('admin.show-cancelled-reservation');
    Route::resource('admin-clinic-gallery', ClinicGalleryController::class);
});
// Route::prefix('doctor')->name('doctor.')->middleware(['doctor', 'auth'])->group(function () {
 Route::prefix('doctor')->middleware('auth:doctor')->group(function () {

    Route::get('/all-reservations', [DoctorDataController::class, 'allReservation'])->name('doctor.all-reservations');
    Route::get('/reservation-filter',[DoctorDataController::class, 'filter'])->name('doctor.reservation-filter');
    Route::get('/complete-reservations', [DoctorDataController::class, 'completeReservation'])->name('doctor.complete-reservations');
    Route::get('/cancelled-reservations', [DoctorDataController::class, 'cancelledReservation'])->name('doctor.cancelled-reservations');
    Route::get('/cancelled-reservation-filter',[DoctorDataController::class, 'cancelledFilter'])->name('doctor.cancelled-reservation-filter');

    Route::get('/show-all-reservation/{id}', [DoctorDataController::class, 'showAllReservation'])->name('doctor.show-all-reservation');
    Route::get('/show-complete-reservation/{id}', [DoctorDataController::class, 'showCompleteReservation'])->name('doctor.show-complete-reservation');
    Route::get('/show-cancelled-reservation/{id}', [DoctorDataController::class, 'showCancelledReservation'])->name('doctor.show-cancelled-reservation');
    //com-action-reservation
    Route::get('/com-action-reservation/{id}', [DoctorDataController::class, 'comReservation'])->name('doctor.com-action-reservation');
    Route::get('/conf-action-reservation/{id}', [DoctorDataController::class, 'confReservation'])->name('doctor.conf-action-reservation');
    //del-action-reservation
    Route::get('/del-action-reservation/{id}', [DoctorDataController::class, 'delReservation'])->name('doctor.del-action-reservation');

    Route::post('/update-reservation', [DoctorDataController::class, 'updateReservation'])->name('doctors.update-reservation');

    Route::get('/doctor-profile/{id}', [DoctorDataController::class, 'doctorProfile'])->name('doctor-profile');
    Route::post('/update-doctor-profile', [DoctorDataController::class, 'updateDoctorProfile'])->name('update-doctor-profile');
    Route::get('/doctor-patients-review', [DoctorDataController::class, 'review'])->name('doctor-patients-review');

    // Charts
    Route::get('/reservations/charts', [DoctorClinicController::class, 'getReservationChartData']);
    Route::resource('doctor-clinic-gallery', DoctorClinicGalleryController::class);

    Route::resource('doctor-clinics', DoctorClinicController::class);
    Route::post('/mark-as-read', [HomeController::class, 'markAsNotification'])->name('markAsNotification');
});
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
 //selectSubMideical.fetch
 Route::get('/selectSubMideical/fetch',[DoctorsController::class, 'selectSubMideical'])->name('selectSubMideical.fetch');


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
Route::get('/reservations/charts', [AdminController::class, 'getReservationChartData']);

});
