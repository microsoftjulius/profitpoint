<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Earnings;
use Carbon\Carbon;
use App\Withdraws;

class EarningsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->investments_instance = new InvestmentsController;
    }

    protected function getEarnings(){
        $logged_in_user_earnings = $this->getLoggedInUserEarnings();
        return view('admin.earnings',compact('logged_in_user_earnings'));
    }

    /**
     * This function gets the total balance of the loggedin User
     * The total balance is gotten from the total earnings someone has subtracting the balance
     */
    public function getMyTotalBalance(){
        return $this->getMyTotalEarnings() - $this->getMyTotalWithDraws();
    }

    /**
     * This function gets the total earnings of a logged in user
     * earnings only happen for a user whose package has been successful
     */
    public function getMyTotalEarnings(){
        return Earnings::where('sponsor_id',auth()->user()->id)->sum('amount') + $this->getDailyBonusEarnings();
    }

    /**
     * This function gets the daily bonus of 2%
     * The daily bonus is gotten everyday at 12:00pm 
     * 
     */
    public function getDailyBonusEarnings(){
        //Initializing the daily bonus
        $daily_bonus = 0;
        //get all the investments a user has made
        $all_loggedin_user_investments = $this->investments_instance->getLoggedinUserInvestments();
        //for every investment, get the day it was created
        foreach($all_loggedin_user_investments as $user_investments){
            //check if the created_at date when subtracted from the day now is less than 100, if its greater, skip it
            if($user_investments->created_at < Carbon::now()->subDays(101)){
                //since its less than 100, generate the bonus
                //this function is called in the cron job every midnight
                $daily_bonus += 0.02 * $user_investments->amount;
            }
        }
        return $daily_bonus;
    }

    /**
     * This function gets the total withdraw amount of the loggedin User 
     */
    public function getMyTotalWithDraws(){
        return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')->sum('amount');
    }

    /**
     * This function gets the collection of withdraws a user has gotten
     * these are the earnings a user gets from the people he brings directly
     * generally, he gets 5% of the amount a referral has used
     */
    private function getLoggedInUserEarnings(){
        return Earnings::where('sponsor_id',auth()->user()->id)->join('users','users.id','earnings.referral_id')
        ->select('users.name','earnings.*')->get();
    }

    /**
     * This function gets the sum of withdraws a loggedin User has made today
     */
    public function getWithdrawsMadeByLoggedinUserToday(){
        return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')
        ->whereDay('created_at',date('d'))
        ->sum('amount');
    }

    /**
     * This function gets the sum of withdraws a loggedin User has made this month
     */
    public function getWithdrawsMadeByLoggedinUserThisMonth(){
        return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')
        ->whereMonth('created_at',date('m'))
        ->sum('amount');
    }

    /**
     * This function gets the total earnings of a loggedin user on this day
     */
    public function getTodaysEarnings(){
        return Earnings::where('sponsor_id',auth()->user()->id)
        ->whereDay('created_at',date('d'))
        ->sum('amount') + $this->getDailyBonusEarnings();
    }

    /**
     * This function gets the total earnings of a loggedin user on this day
     */
    public function getThisMonthsEarnings(){
        return Earnings::where('sponsor_id',auth()->user()->id)
        ->whereMonth('created_at',date('m'))
        ->sum('amount') + $this->getDailyBonusEarnings();
    }

    /**
     * This function gets loggedin users todays account balance
     */
    public function getLoggedInUsersTodaysEarnings(){
        return $this->getTodaysEarnings() - $this->getWithdrawsMadeByLoggedinUserToday();
    }

    /**
     * This function gets loggedin users months account balance
     */
    public function getLoggedInUsersMonthsEarnings(){
        return $this->getThisMonthsEarnings() - $this->getWithdrawsMadeByLoggedinUserThisMonth();
    }
}
