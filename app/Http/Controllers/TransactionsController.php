<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->withdraws_instance = new WithdrawsController;
        $this->investments_instance = new InvestmentsController;
        $this->dollar_rates_instance  = new DollarRatesController;
    }

    /**
     * This function gets the transactions a user has made
     */
    protected function getTransactions(){
        $my_withdraws = $this->withdraws_instance->getLoggedInUsersWithdrawsCollection();
        $my_deposits  = $this->investments_instance->getLoggedinUserInvestments();
        $transactions = collect([$my_deposits, $my_withdraws]);
        $dollar_rate = $this->dollar_rates_instance->getDollarRate();
        return view('admin.transaction',compact('transactions','dollar_rate'));
    }

    /**
     * This function gets all the transactions and displays them to an admin
     */
    protected function getAllTransactions(){
        $all_withdraws = $this->withdraws_instance->getAllWithdrawsToAdmin();
        $all_deposits  = $this->investments_instance->getLoggedinUserInvestments();
        $transactions = collect([$all_deposits, $all_withdraws]);
        $dollar_rate = $this->dollar_rates_instance->getDollarRate();
        return view('admin.transaction_overview',compact('transactions','dollar_rate'));
    }
}
