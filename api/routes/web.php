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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function() {
    Route::get('accounts/{id}', function ($id) {
        $account = DB::table('accounts')
            ->whereRaw("id=$id")
            ->get();

        return $account;
    });

    Route::get('accounts/{id}/transactions', function ($id) {
        $account = DB::table('transactions')
            ->whereRaw("`from`=$id OR `to`=$id")
            ->get();

        return $account;
    });

    Route::post('accounts/{id}/transactions', function (Request $request, $id) {
        $to = $request->input('to');
        $amount = $request->input('amount');
        $details = $request->input('details');

        $account = DB::table('accounts')
            ->whereRaw("id=$id")
            ->update(['balance' => DB::raw('balance-' . $amount)]);

        $account = DB::table('accounts')
            ->whereRaw("id=$to")
            ->update(['balance' => DB::raw('balance+' . $amount)]);

        DB::table('transactions')->insert(
            [
                'from' => $id,
                'to' => $to,
                'amount' => $amount,
                'details' => $details
            ]
        );
    });

    Route::get('currencies', function () {
        $account = DB::table('currencies')
            ->get();

        return $account;
    });
});
