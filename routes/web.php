<?php

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

Route::view('/', 'welcome')->name('welcome');

Route::middleware(['auth', 'verified'])->group(function (){
	Route::get('profile', 'ProfileController@index')->name('profile');
	Route::patch('profile/coordinator/update', 'ProfileController@coordinatorUpdate')->name('profile.coordinator-update');

	Route::get('dashboard', 'DashboardController@index')->name('dashboard');

	Route::get('proposals/waiting-list', 'ProposalController@waitingList')->name('proposals.waiting-list');
	Route::resource('proposals', ProposalController::class);

	Route::resource('berkas', PdfmakerController::class);

	Route::patch('students/reset-password/{student}', 'StudentController@resetPassword')
		->name('students.reset-password')
		->middleware('password.confirm');
	Route::resource('students', StudentController::class)->only([
		'index', 'show'
	]);
	Route::resource('students', StudentController::class)->only([
		'destroy'
	])->middleware('password.confirm');

	Route::resource('prodi', ProdiController::class)->only([
		'index', 'show', 'edit', 'update'
	]);

	Route::resource('settings', SettingController::class)->only(['index', 'edit', 'update']);
});
