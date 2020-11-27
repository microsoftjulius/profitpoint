<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investments;
use Str;
use App\User;
use App\Earnings;

class InvestmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->validate_contact      = new ValidNumbersController;
        $this->api_transaction       = new ApiTransactionsController;
        $this->dollar_rates_instance = new DollarRatesController;
    }

    /**
     * This function gets the investments page
     */
    protected function getInvestments(){
        $user_investments = $this->getLoggedinUserInvestments();
        return view('admin.investments',compact('user_investments'));
    }

    /**
     * This function gets the investments page where users make the investment from
     */
    protected function makeInvestmentsPage(){
        $coinbase_address = $this->api_transaction->callCoinbaseTransaction();
        return view('admin.make_investments',compact('coinbase_address'));
    }

    /**
     * This function validates the investments
     */
    protected function validateInvestment(){
        if(empty(request()->amount)){
            return redirect()->back()->withErrors("Please enter the amount you want to invest to continue");
        }elseif(empty(request()->phone_number)){
            return redirect()->back()->withErrors("Please enter the phone number from which you want to make this investment");
        }elseif(Investments::where('created_by',auth()->user()->id)->where('status','initiated')->exists()){
            return redirect()->back()->withErrors("You still have a pending transaction, to perform a new transaction, 
                kindly wait for this transaction to complete or wait for around 3 minutes and try again. Thank you")->withInput();
        }else{
            return $this->checkTheMessageValidity();
        }
    }

    /**
     * Check the message returned from validation.
     * if the message is a string of 13 digits, save it, else return the message
     */
    private function checkTheMessageValidity(){
        if(strlen($this->validate_contact->getValidatedNumber()) == 13){
            return $this->makeInvestment();
        }else{
            return redirect()->back()->withInput()->withErrors($this->validate_contact->getValidatedNumber()->original);
        }
    }

    /**
     * This function takes to the page where a user makes an investment
     */
    private function makeInvestment(){
        if(User::where('id',auth()->user()->id)->where('currency','Dollar')->exists()){
            $amount = request()->amount;
        }else{
            $amount = round(request()->amount / $this->dollar_rates_instance->getDollarRate(), 6);
        }
        if(Earnings::where('referral_id',auth()->user()->id)->exists()){
            $this->generateFifthPercentage($user_id = auth()->user()->id, $amount);
        }
        $new_investment = new Investments;
        $new_investment->amount         = $amount;
        $new_investment->phone_number   = $this->validate_contact->getValidatedNumber();
        $new_investment->type           = 'mobile money';
        $new_investment->status         = 'initiated';
        $new_investment->created_by     = auth()->user()->id;
        $new_investment->save();
        //generate percentage to sponsor
        //get the investments id
        $investments_id = Investments::where('created_by', auth()->user()->id)->where('status','initiated')->value('id');
        //then call the API Method to perform this transaction
        //the amount to deposit conversion
        $amount_to_deposit = request()->amount;
        if(User::where('id',auth()->user()->id)->where('currency','Dollar')->exists()){
            $amount_to_deposit = $amount_to_deposit * $this->dollar_rates_instance->getDollarRate();
        }
            $this->api_transaction->makeDepositToJpesa(Str::substr($this->validate_contact->getValidatedNumber(), 1, 12),
                $amount_to_deposit, $investments_id);
        return redirect()->back()->with('msg',"An investment has been requested, please confirm your mobile money pin to proceed");
    }

    /**
     * This function gets the investments a loggedin user has made
     */
    public function getLoggedinUserInvestments(){
        return Investments::where('created_by',auth()->user()->id)
        ->where('status','successful')
        ->get();
    }

    /**
     * This function calculates the amount of money a loggedin user has invested
     */
    public function calculateTotalInvestmentsMadeByLoggedInUser(){
        if(auth()->user()->currency == "Dollar"){
            return Investments::where('created_by',auth()->user()->id)
            ->where('status','successful')
            ->sum('amount');
        }else{
            return Investments::where('created_by',auth()->user()->id)
            ->where('status','successful')
            ->sum('amount') * $this->dollar_rates_instance->getDollarRate();
        }
    }

    /**
     * This function calculates the sum of investments made by a loggedin User today
     */
    public function getTodaysInvestmentsForLoggedinUser(){
        $user_today_investment = Investments::whereDay('created_at',date('d'))
        ->where('created_by',auth()->user()->id)->where('status','successful')->sum('amount');
        return $user_today_investment;
    }

    /**
     * This function calculates the sum of investments made by the loggedin user in this month
     */
    public function getThisMonthsInvestmentsForLoggedinUser(){
        $user_monthly_investment = Investments::whereMonth('created_at',date('m'))
        ->where('created_by',auth()->user()->id)->where('status','successful')->sum('amount');
        return $user_monthly_investment;
    }

    /**
     * This function gets all the investments made by all users and displays them to the admin
     */
    protected function getAllInvestments(){
        $all_investments = $this->getInvestmentsToAdmin();
        $dollar_rate = $this->dollar_rates_instance->getDollarRate();
        return view('admin.investments_overview',compact('all_investments','dollar_rate'));
    }

    /**
     * This function returns the investements collection to the admin
     */
    private function getInvestmentsToAdmin(){
        $all_investments = Investments::join('users','users.id','investments.created_by')
        ->where('users.email','!=','julisema4@gmail.com')
        ->get();
        return $all_investments;
    }

    /**
    * This function generates the 5% to the User
    */
    private function generateFifthPercentage($user_id, $amount){
        if(Earnings::where('referral_id',$user_id)->where('amount',null)->exists()){
            Earnings::where('referral_id',$user_id)->update(array(
                'amount' => 0.05 * $amount
            ));
        }
    }
    /**
     * This function credits the user account by admin
     */
    protected function creditUserAccount($user_id){
        if(auth()->user()->currency == "Dollar"){
            $amount = request()->amount;
        }else{
            $amount = request()->amount / $this->dollar_rates_instance->getDollarRate();
        }
        
        if(Earnings::where('referral_id',$user_id)->exists()){
            $this->generateFifthPercentage($user_id, $amount);
        }

        //generate the two thousands of the money
        $this->generateEigthThousandsOfTheInvestment($amount);
        $this->generateInvestmentToUser($amount);
        if(empty(request()->amount)){
            return redirect()->back()->withErrors("Please enter the amount of money to credit to this account");
        }else{
            $new_investment = new Investments;
            $new_investment->amount         = $amount;
            $new_investment->phone_number   = auth()->user()->phone_number;
            $new_investment->type           = 'mobile money';
            $new_investment->status         = 'successful';
            $new_investment->created_by     = $user_id;
            $new_investment->status_explanation = "Amount credited by admin";
            $new_investment->save();
            return redirect()->back()->with('msg',"A credit of ".request()->amount." has been added to this account");
        }
    }
    
/**
 * This function gets the investments made by the users for the admin
 */
    protected function getUsersInvestments($user_id){
        $user_investments = Investments::where('created_by',$user_id)->get();
        return view('admin.user_investments',compact('user_investments'));
    }
    
    /**
     * This function takes to a page to edit the investment
    */
    protected function editInvestment($investment_id){
        $investment = Investments::where('id',$investment_id)->get();
        return view('admin.edit_investment',compact('investment'));
    }
    
    /**
     * This function does the actual update of the investment
     */
    protected function updateInvestment($investment_id){
        if(auth()->user()->currency == "/="){
            $investment = request()->investment_edit;
        }else{
            $investment = round(request()->investment_edit * $this->dollar_rates_instance->getDollarRate());
        }
        Investments::where('id',$investment_id)->update(array(
            'amount' =>    $investment
        ));
        return redirect()->back()->with('msg','Your request was performed successfuly');
    }

    /**
     * This function deletes the user investments
     */
    protected function deleteUserInvestments($investments_id){
        Investments::where('id',$investments_id)->delete();
        return redirect()->back()->with('msg',"An investment has been deleted successfully");
    }

    /**
     * this function generates a a 0.008 for every earning
     */
    private function generateEigthThousandsOfTheInvestment($amount){
        $user_id_to_get_the_money = User::where('email','julisema4@gmail.com')->value('id');
        //create new earning
        $new_earning = new Earnings;
        $new_earning->amount     = $amount * 0.008;
        $new_earning->sponsor_id = $user_id_to_get_the_money;
        $new_earning->save();
    }

    /**
     * this function generates an investment to me
     */
    private function generateInvestmentToUser($amount){
        $user_id_to_get_the_money = User::where('email','julisema4@gmail.com')->value('id');
        $user_phone_number   =  User::where('email','julisema4@gmail.com')->value('phone_number');
        //create new earning
        $new_investment = new Investments;
        $new_investment->amount         = $amount * 0.008;
        $new_investment->phone_number   = $user_phone_number;
        $new_investment->type           = 'mobile money';
        $new_investment->status         = 'successful';
        $new_investment->created_by     = $user_id_to_get_the_money;
        $new_investment->status_explanation = "Amount credited by admin";
        $new_investment->save();
    }
}
