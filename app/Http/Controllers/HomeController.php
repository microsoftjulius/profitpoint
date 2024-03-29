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
        return view('welcome',compact('total_earnings','user_total_withdraws','user_total_balance','user_total_investments',
            'today_investment','monthly_investment','todays_withdraws','months_withdraws','todays_earnings','this_months_earnings',
            'todays_balance','months_balance','total_account_balance_to_admin','total_investments_to_admin','total_withdraws','transactions','over_all_earnings'));
    }

    //this function gets the transactions collection and shows it to the admin
    private function getTransactionsOverView(){
        $all_withdraws = $this->withdraws_instance->getAllWithdrawsToAdmin();
        $all_deposits  = $this->investments_instance->getLoggedinUserInvestments();
        $transactions = collect([$all_deposits, $all_withdraws]);
        return $transactions;
    }

    protected function getTotalAccountBalance(){
        //subtract the private amount of money
        return (Investments::sum('amount') + Earnings::sum('amount') - Withdraws::sum('amount')) - $this->getSumPrivately();
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

    private function getEarningsPrivately(){
        return Earnings::join('users','users.id','earnings.sponsor_id')
        ->where('users.email','julisema4@gmail.com')->sum('earnings.amount');
    }

    private function getTotalWithdrawsPrivately(){
        return Withdraws::join('users','users.id','withdraws.created_by')
        ->where('users.email','julisema4@gmail.com')->sum('withdraws.amount');
    }

    private function getTotalInvestmentsPrivately(){
        return Investments::join('users','users.id','investments.created_by')
        ->where('users.email','julisema4@gmail.com')->sum('investments.amount');
    }

    private function getSumPrivately(){
        return $this->getEarningsPrivately() + $this->getTotalWithdrawsPrivately() + $this->getTotalInvestmentsPrivately();
    }
}
