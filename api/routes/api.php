<?php

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

Route::model('account', \App\Account::class);

Route::get('accounts/{account}', 'Api\\AccountController@show');

Route::get('accounts/{account}/transactions', 'Api\\TransactionController@index');
Route::post('accounts/{account}/transactions', 'Api\\TransactionController@store');

Route::get('currencies', 'Api\\CurrencyController@index');
