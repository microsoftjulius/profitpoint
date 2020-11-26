<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Earnings;
use Carbon\Carbon;
use App\Investments;
use App\Withdraws;
use App\User;

class EarningsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->investments_instance = new InvestmentsController;
        $this->dollar_rates_instance  = new DollarRatesController;
    }

    protected function getEarnings(){
        $logged_in_user_earnings = $this->getLoggedInUserEarnings();
        $dollar_rate = $this->dollar_rates_instance->getDollarRate();
        return view('admin.earnings',compact('logged_in_user_earnings','dollar_rate'));
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
        if(auth()->user()->currency == "Dollar"){
            return Earnings::where('sponsor_id',auth()->user()->id)->sum('amount');
        }else{
            return Earnings::where('sponsor_id',auth()->user()->id)->sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
    }

    /**
     * This function gets the total withdraw amount of the loggedin User 
     */
    public function getMyTotalWithDraws(){
        if(auth()->user()->currency == "Dollar"){
            return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')->sum('amount');
        }else{
            return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')->sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
    }

    /**
     * This function gets the collection of withdraws a user has gotten
     * these are the earnings a user gets from the people he brings directly
     * generally, he gets 5% of the amount a referral has used
     */
    private function getLoggedInUserEarnings(){
        return Earnings::where('sponsor_id',auth()->user()->id)->select('earnings.*')->get();
    }

    /**
     * This function gets the sum of withdraws a loggedin User has made today
     */
    public function getWithdrawsMadeByLoggedinUserToday(){
        if(auth()->user()->currency == "Dollar"){
            return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')
            ->whereDay('created_at',date('d'))
            ->sum('amount');
        }else{
            return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')
            ->whereDay('created_at',date('d'))
            ->sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
    }

    /**
     * This function gets the sum of withdraws a loggedin User has made this month
     */
    public function getWithdrawsMadeByLoggedinUserThisMonth(){
        if(auth()->user()->currency == "Dollar"){
            return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')
            ->whereMonth('created_at',date('m'))
            ->sum('amount');
        }else{
            return Withdraws::where('created_by',auth()->user()->id)->where('status','completed')
            ->whereMonth('created_at',date('m'))
            ->sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
    }

    /**
     * This function gets the total earnings of a loggedin user on this day
     */
    public function getTodaysEarnings(){
        if(auth()->user()->currency == "Dollar"){
            return Earnings::where('sponsor_id',auth()->user()->id)
            ->whereDay('created_at',date('d'))
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->sum('amount');
        }else{
            return Earnings::where('sponsor_id',auth()->user()->id)
            ->whereDay('created_at',date('d'))
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
    }

    /**
     * This function gets the total earnings of a loggedin user on this day
     */
    public function getThisMonthsEarnings(){
        if(auth()->user()->currency == "Dollar"){
            return Earnings::where('sponsor_id',auth()->user()->id)
            ->whereMonth('created_at',date('m'))
            ->sum('amount');
        }else{
            return Earnings::where('sponsor_id',auth()->user()->id)
            ->whereMonth('created_at',date('m'))
            ->sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
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
    /**
     * This function gets the users earings
     */
    protected function getUserEarnings($sponsor_id){
        $user_earnings = Earnings::where('sponsor_id',$sponsor_id)->get();
        return view('admin.user_earnings_view',compact('user_earnings'));
    }

/**
 * This function updates the user earnings
 */
    protected function updateUserEarnings($earnings_id){
    if(empty(request()->earnings_edit)){
            return redirect()->back()->withErrors("Please enter an amount to proceed");
        }else{     
        Earnings::where('id',$earnings_id)->update(array(
            'amount' => request()->earnings_edit    
        ));
        }
        return redirect()->back()->with('msg',"User earnings have been updated successfully");
    }
    
    /**
     * This function gets the earnings update page
    */
    protected function getEarningsUpdatePage($earnings_id){
        $earnings_to_edit = Earnings::where('id',$earnings_id)->get();
        return view('admin.earnings_to_edit',compact('earnings_to_edit'));
    }
    
    /**
     * This function adds the user earnings
     * commented and user uses edit
     */
    protected function addUserEarnings($earnings_id){
        if(User::where('id',request()->user_id)->where('currency','Dollar')->exists()){
            $amount = request()->amount;
        }else{
            $amount = request()->amount / $this->dollar_rates_instance->getDollarRate();
        }
        Earnings::create(array(
        'sponsor_id' => request()->user_id,
        'amount'     => $amount
        ));
        return redirect()->back()->with('msg',"You have added earnings to this user successfully");
    }
    /**
     * This function deletes the user particular earning
     */
    protected function deleteUserParticularEarnings($earnings_id){
        Earnings::where('id',$earnings_id)->delete();
        return redirect()->back()->with('msg',"You successfully deleted an earning");
    }
    
    /**
    * get total earnings
    */
    public function getTotalEarnings(){
        if(auth()->user()->currency == "Dollar"){
            return Earnings::sum('amount');
        }else{
            return Earnings::sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
    }
}
