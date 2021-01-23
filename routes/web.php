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

/* For Authenticated and email verified */
Route::middleware(['auth', 'verified'])->group(function (){
	Route::get('profile', 'ProfileController@index')->name('profile');

	/* For Verified Students or admin, coor (Check KTM) */
	Route::middleware('student-valid')->group(function (){
		Route::get('dashboard', 'DashboardController@index')->name('dashboard');

		Route::resource('proposals', ProposalController::class);

		Route::resource('/berkas', PdfmakerController::class);
	});

});
