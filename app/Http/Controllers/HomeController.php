<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Earnings;
use App\Investments;
use App\Withdraws;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->dollar_rates_instance = new DollarRatesController;
        $this->earnings_instance     = new EarningsController;
        $this->investments_instance  = new InvestmentsController;
        $this->withdraws_instance    = new WithdrawsController;
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->currency == "/="){
            $total_earnings         = $this->earnings_instance->getMyTotalEarnings() * $this->dollar_rates_instance->getDollarRate();
            $user_total_withdraws   = $this->earnings_instance->getMyTotalWithDraws()  * $this->dollar_rates_instance->getDollarRate();
            $user_total_balance     = $this->earnings_instance->getMyTotalBalance();
            $user_total_investments = $this->investments_instance->calculateTotalInvestmentsMadeByLoggedInUser()  * $this->dollar_rates_instance->getDollarRate();
            $today_investment       = $this->investments_instance->getTodaysInvestmentsForLoggedinUser() * $this->dollar_rates_instance->getDollarRate();
            $monthly_investment     = $this->investments_instance->getThisMonthsInvestmentsForLoggedinUser() * $this->dollar_rates_instance->getDollarRate();
            $todays_withdraws       = $this->earnings_instance->getWithdrawsMadeByLoggedinUserToday()  * $this->dollar_rates_instance->getDollarRate();
            $months_withdraws       = $this->earnings_instance->getWithdrawsMadeByLoggedinUserThisMonth() * $this->dollar_rates_instance->getDollarRate();
            $todays_earnings        = $this->earnings_instance->getTodaysEarnings() * $this->dollar_rates_instance->getDollarRate();
            $this_months_earnings   = $this->earnings_instance->getThisMonthsEarnings() * $this->dollar_rates_instance->getDollarRate();
            $todays_balance         = $this->earnings_instance->getLoggedInUsersTodaysEarnings() * $this->dollar_rates_instance->getDollarRate();
            $months_balance         = $this->earnings_instance->getLoggedInUsersMonthsEarnings() * $this->dollar_rates_instance->getDollarRate();
            $total_account_balance_to_admin = $this->getTotalAccountBalance() * $this->dollar_rates_instance->getDollarRate();
            $total_investments_to_admin = $this->getTotalInvestments() * $this->dollar_rates_instance->getDollarRate();
            $total_withdraws = $this->getTotalWithdraws() * $this->dollar_rates_instance->getDollarRate();
            $transactions    = $this->getTransactionsOverView();
            $over_all_earnings = $this->earnings_instance->getTotalEarnings() * $this->dollar_rates_instance->getDollarRate();
        }else{
            $total_earnings         = $this->earnings_instance->getMyTotalEarnings();
            $user_total_withdraws   = $this->earnings_instance->getMyTotalWithDraws();
            $user_total_balance     = $this->earnings_instance->getMyTotalBalance();
            $user_total_investments = $this->investments_instance->calculateTotalInvestmentsMadeByLoggedInUser();
            $today_investment       = $this->investments_instance->getTodaysInvestmentsForLoggedinUser();
            $monthly_investment     = $this->investments_instance->getThisMonthsInvestmentsForLoggedinUser();
            $todays_withdraws       = $this->earnings_instance->getWithdrawsMadeByLoggedinUserToday();
            $months_withdraws       = $this->earnings_instance->getWithdrawsMadeByLoggedinUserThisMonth();
            $todays_earnings        = $this->earnings_instance->getTodaysEarnings();
            $this_months_earnings   = $this->earnings_instance->getThisMonthsEarnings();
            $todays_balance         = $this->earnings_instance->getLoggedInUsersTodaysEarnings();
            $months_balance         = $this->earnings_instance->getLoggedInUsersMonthsEarnings();
            $total_account_balance_to_admin = $this->getTotalAccountBalance();
            $total_investments_to_admin = $this->getTotalInvestments();
            $total_withdraws = $this->getTotalWithdraws();
            $transactions    = $this->getTransactionsOverView();   
            $over_all_earnings = $this->earnings_instance->getTotalEarnings();
        }
        $dollar_rate = $this->dollar_rates_instance->getDollarRate();
        return view('welcome',compact('total_earnings','user_total_withdraws','user_total_balance','user_total_investments',
            'today_investment','monthly_investment','todays_withdraws','months_withdraws','todays_earnings','this_months_earnings',
            'todays_balance','months_balance','total_account_balance_to_admin','total_investments_to_admin','total_withdraws','transactions','over_all_earnings','dollar_rate'));
    }

    //this function gets the transactions collection and shows it to the admin
    private function getTransactionsOverView(){
        $all_withdraws = $this->withdraws_instance->getAllWithdrawsToAdmin();
        $all_deposits  = $this->investments_instance->getLoggedinUserInvestments();
        $transactions = collect([$all_deposits, $all_withdraws]);
        return $transactions;
    }

    protected function getTotalAccountBalance(){
        return Investments::sum('amount') + Earnings::sum('amount') - Withdraws::sum('amount');
    }

    protected function getTotalInvestments(){
        return Investments::sum('amount') + $this->getTotalEarnings();
    }

    protected function getTotalWithdraws(){
        return Withdraws::sum('amount');
    }
    
    protected function getTotalEarnings(){
        return Earnings::sum('amount');
    }
}
