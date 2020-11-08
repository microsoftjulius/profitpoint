<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//for exchange rate using https://github.com/ash-jc-allen/laravel-exchange-rates
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Carbon\Carbon;

class DollarRatesController extends Controller
{
    /**
     * This function gets the dollar rate
     */
    public function getDollarRate(){
        $dollar_rate = "3700";
        return $dollar_rate;
    }
}
