<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//for exchange rate using https://github.com/ash-jc-allen/laravel-exchange-rates
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Carbon\Carbon;

class DollarRatesController extends Controller
{

    protected static $amount_to_reduce = 1000;
    /**
     * This function gets the dollar rate
     */
    public function getDollarRate(){
        $dollar_rate = "3700";
        return $dollar_rate;
    }

    /**
     * this function returns the amount of money that is to be reduced from the withdraw a user makes
     */
    public function removeAPercentage($user_id){
        if(auth()->user()->role_id == 1){
            $user_currency = User::where('id',$user_id)->value('currency');
            if($user_currency == 'Dollar'){
                return Self::$amount_to_reduce / $this->getDollarRate();
            }else{
                return Self::$amount_to_reduce;
            }
        }else{
            if(auth()->user()->currency == 'Dollar'){
                return Self::$amount_to_reduce / $this->getDollarRate();
            }else{
                return Self::$amount_to_reduce;
            }
        }
    }
}
