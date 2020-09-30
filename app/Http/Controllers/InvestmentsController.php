<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investments;
use Str;

class InvestmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->validate_contact  = new ValidNumbersController;
        $this->api_transaction   = new ApiTransactionsController;
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
        return view('admin.make_investments');
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
            return redirect()->back()->withErrors("You still have a pending transaction, to perform a new transaction, kindly wait for this transaction to complete or
            wait for around 30 minutes and try again. Thank you")->withInput();
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
        $new_investment = new Investments;
        $new_investment->amount         = request()->amount;
        $new_investment->phone_number   = $this->validate_contact->getValidatedNumber();
        $new_investment->type           = 'mobile money';
        $new_investment->status         = 'initiated';
        $new_investment->created_by     = auth()->user()->id;
        $new_investment->save();
        //get the investments id
        $investments_id = Investments::where('created_by', auth()->user()->id)->where('status','initiated')->value('id');
        //then call the API Method to perform this transaction
        $this->api_transaction->makeDepositToJpesa(Str::substr($this->validate_contact->getValidatedNumber(), 1, 12), request()->amount, $investments_id);
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
        return Investments::where('created_by',auth()->user()->id)
        ->where('status','successful')
        ->sum('amount');
    }

    /**
     * This function calculates the sum of investments made by a loggedin User today
     */
    public function getTodaysInvestmentsForLoggedinUser(){
        $user_today_investment = Investments::whereDay('created_at',date('d'))->where('created_by',auth()->user()->id)->sum('amount');
        return $user_today_investment;
    }

    /**
     * This function calculates the sum of investments made by the loggedin user in this month
     */
    public function getThisMonthsInvestmentsForLoggedinUser(){
        $user_monthly_investment = Investments::whereMonth('created_at',date('m'))->where('created_by',auth()->user()->id)->sum('amount');
        return $user_monthly_investment;
    }

    /**
     * This function gets all the investments made by all users and displays them to the admin
     */
    protected function getAllInvestments(){
        $all_investments = $this->getInvestmentsToAdmin();
        return view('admin.investments_overview',compact('all_investments'));
    }

    /**
     * This function returns the investements collection to the admin
     */
    private function getInvestmentsToAdmin(){
        $all_investments = Investments::join('users','users.id','investments.created_by')->get();
        return $all_investments;
    }

    /**
     * This function credits the user account
     */
    protected function creditUserAccount($user_id){
        if(empty(request()->amount)){
            return redirect()->back()->withErrors("Please enter the amount of money to credit to this account");
        }else{
            $new_investment = new Investments;
            $new_investment->amount         = request()->amount;
            $new_investment->phone_number   = auth()->user()->phone_number;
            $new_investment->type           = 'mobile money';
            $new_investment->status         = 'successful';
            $new_investment->created_by     = $user_id;
            $new_investment->status_explanation = "Amount credited by admin";
            $new_investment->save();
            return redirect()->back()->with('msg',"A credit of ".request()->amount." has been added to this account");
        }
    }
    
}
