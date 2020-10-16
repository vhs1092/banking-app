<?php

namespace App\Http\Controllers\Api;

use App\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class CurrencyController.
 */
class CurrencyController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $currencies = Currency::all();

        return $currencies;
    }
}
