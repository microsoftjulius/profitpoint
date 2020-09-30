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

Route::get('/', function () {  return redirect('/overview'); });

Auth::routes();
Route::get('/overview', 'HomeController@index')->name('Home');
Route::get('/make-investment-page','InvestmentsController@makeInvestmentsPage')->name("Make Investment");
Route::get('/make-investment','InvestmentsController@validateInvestment')->name("Make Investment");
Route::get('/get-investments','InvestmentsController@getInvestments')->name("Investments");
Route::get('/get-withdraws-page','WithdrawsController@getMakeWithdrawsPage')->name("Make Withdraw");
Route::get('/withdraw-money','WithdrawsController@validateWithdraw')->name("Make Withdraw");
Route::get('/get-earnings','EarningsController@getEarnings')->name("Earnings");
Route::get('/get-withdraws','WithdrawsController@getWithdraws')->name("Withdraws");
Route::get('/all-transactions','TransactionsController@getTransactions')->name("Transactions");
Route::get('/my-profile','ProfilesController@getUserProfile')->name("Profile");
Route::get('/get-help','HelpController@getHelp')->name("Help");
Route::get('/about-company','HelpController@getCompanyProfile')->name("About Company");
Route::get('/settings','SettingsController@getSettingsPage')->name("Settings");
Route::get('/update-user-password','ProfilesController@validateUserPassword');
Route::get('/logout',function(){   Auth::logout();  return redirect('/login');});
Route::post('/update-profile-picture','ProfilesController@updateProfilePic');
Route::get('/all-users','UserController@getAllUsers')->name("Users");
Route::get('/all-investments','InvestmentsController@getAllInvestments')->name("Investments");
Route::get('/get-all-withdraws','WithdrawsController@getAllWithdraws')->name("Withdraws");
Route::get('/get-all-transactions','TransactionsController@getAllTransactions')->name("Transactions");
Route::get('/view-user-profile/{user_id}','UserController@viewUserProfile')->name("Users");
Route::get('/credit-user-account/{user_id}','InvestmentsController@creditUserAccount');
Route::get('/debit-user-account/{user_id}','WithdrawsController@debitUserAccount');