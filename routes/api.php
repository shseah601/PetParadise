<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

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
Route::middleware(['auth:api'])->group(function () {
  Route::post('logout', 'Auth\LoginController@logout');

  Route::get('/user', function (Request $request) {
    $user = $request->user();
    $role = $user->roles()->pluck('id')->first();
    if ($role == 1) {
      $user = $user->load('admin');
    } else if($role == 2) {
      $user = $user->load('employee');
    } else {
      $user = $user->load('client');
    }
    return $user;
  });

  Route::patch('settings/profile', 'Settings\UpdateProfile');
  Route::patch('settings/password', 'Settings\UpdatePassword');

  Route::apiResource('company', 'CompanyController');
  // Route::post('company/{id}', 'CompanyController@update');
  Route::apiResource('clients', 'ClientController');
  Route::apiResource('employees', 'EmployeeController');
  Route::apiResource('pendingBookings', 'PendingBookingController');
  Route::get('clientPendingBookings/{id}', 'PendingBookingController@getClientPendingBookings');
  Route::apiResource('bookings', 'BookingController');
  Route::get('clientBookings/{id}', 'BookingController@getClientBookings');
  Route::apiResource('pets', 'PetController');
  Route::get('clientPets/{id}', 'PetController@getClientPets');
  Route::apiResource('services', 'ServiceController');
  Route::apiResource('workinghours', 'WorkingHourController')->except(['update']);
  Route::post('updateWorkingHours', 'WorkingHourController@updateWorkingHours');
});

//admin
Route::middleware(['auth:api', 'can:manage-company'])->group(function () {
  Route::apiResource('company', 'CompanyController')->only([
    'store',
    'update'
  ]);
  Route::apiResource('workinghours', 'WorkingHourController')->only([
    'store',
    'update'
  ]);
});

//admin
Route::middleware(['auth:api', 'can:manage-employees'])->group(function () {
  Route::apiResource('employees', 'EmployeeController')->only([
    'store',
    'update'
  ]);
});

//admin, employee
Route::middleware(['auth:api', 'can:manage-admin-panel'])->group(function () {
  Route::apiResource('clients', 'ClientController')->only([
    'store',
    'update'
  ]);
  Route::apiResource('pendingbookings', 'PendingBookingController')->only([
    'store',
    'update'
  ]);
  Route::apiResource('bookings', 'BookingController')->only([
    'store',
    'update'
  ]);
});

//admin, employee, client
Route::middleware(['auth:api', 'can:manage-bookings'])->group(function () {
  Route::apiResource('bookings', 'BookingController')->only([
    'store',
    'update'
  ]);
  Route::apiResource('pendingBookings', 'PendingBookingController')->only([
    'store',
    'update'
  ]);
});
//admin, employee, client
Route::middleware(['auth:api', 'can:manage-pets'])->group(function () {
  Route::apiResource('pets', 'PetController')->only([
    'store',
    'update'
  ]);
});

Route::middleware(['guest:api'])->group(function () {
  Route::post('login', 'Auth\LoginController@login');
  Route::post('register', 'ClientController@store');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});