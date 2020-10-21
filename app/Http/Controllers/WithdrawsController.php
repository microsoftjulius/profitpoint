<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Withdraws as Withdraw;
use Str;
use App\User;

class WithdrawsController extends Controller
{
    protected static $minimum_amount_to_withdraw = '5000';
    protected static $maximum_amount_to_withdraw = '50000000';

    public function __construct()
    {
        $this->middleware('auth');
        $this->earnings_instance      = new EarningsController;
        $this->api_transaction        = new ApiTransactionsController;
        $this->validate_contact       = new ValidNumbersController;
    }
    /**
     * This function takes to the withdraws page
     */
    protected function getMakeWithdrawsPage(){
        return view("admin.make_withdraws");
    }

    /**
     * This function gets the withdraws a user has made
     */
    protected function getWithdraws(){
        $logged_in_user_withdraws_collection = $this->getLoggedInUsersWithdrawsCollection();
        return view('admin.withdraws',compact('logged_in_user_withdraws_collection'));
    }

    /**
     * This function validates the withdraw
     */
    protected function validateWithdraw(){
        if(!ctype_digit(request()->withdraw_amount)){
            return redirect()->back()->withInput()->withErrors("Please enter a valid amount of money to proceed, money should completely be interger eg, 500000 for 500,000");
        }elseif(request()->withdraw_amount > $this->earnings_instance->getMyTotalBalance()){
            return redirect()->back()->withInput()->withErrors("You have insufficient balance to make this transaction");
        }elseif(request()->withdraw_amount < Self::$minimum_amount_to_withdraw){
            return redirect()->back()->withInput()->withErrors("Please request a withdraw that is equal or greater than ". Self::$minimum_amount_to_withdraw);
        }elseif(request()->withdraw_amount > Self::$maximum_amount_to_withdraw){
            return redirect()->back()->withInput()->withErrors("Please request a withdraw that is equal or less than ". Self::$maximum_amount_to_withdraw);
        }elseif(Withdraw::where('created_by',auth()->user()->id)->where('transaction_id',null)->where('status','pending')->exists()){
            return redirect()->back()->withInput()->withErrors("You will ba able to request a next withdraw in the next 30 minutes or when the previous withdraw request you performed is successful");
        }elseif(request()->withdraw_amount < $this->earnings_instance->getMyTotalBalance()){
            if(Hash::check(request()->password,auth()->user()->password)){
                return $this->saveWithdrawRequest();
            }else{
                return redirect()->back()->withInput()->withErrors("Please Enter a valid password to proceed");
            }
        }
    }

    /**
     * This function gets the total withdraw amount of the loggedin User 
     */
    public function getMyTotalWithDraws(){
        return Withdraw::where('created_by',auth()->user()->id)->where('status','completed')->sum('amount');
    }

    /**
     * This function saves the withdraw request and calls the withdraw
     * method to performthe withdraw
     */
    private function saveWithdrawRequest(){
        $new_withdraw = new Withdraw;
        $new_withdraw->amount = request()->withdraw_amount;
        $new_withdraw->status = 'pending';
        $new_withdraw->created_by = auth()->user()->id;
        $new_withdraw->save();
        //then call the function to perfom a withdraw transaction
        $this->api_transaction->withdrawMoneyFromJpesa(Str::substr(auth()->user()->phone_number,1,12), request()->withdraw_amount);
        return redirect()->back()->with('msg','A withdraw transaction request has been processed successfully');
    }

    /**
     * This function gets the collection of all the withdraws a loggedin user has made
     */
    public function getLoggedInUsersWithdrawsCollection(){
        return Withdraw::join('users','users.id','withdraws.created_by')
        ->where('created_by',auth()->user()->id)
        ->select('users.phone_number','withdraws.*')
        ->get();
    }

    /**
     * This function gets the withdraws all users have made and displays it to the admin
     */
    protected function getAllWithdraws(){
        $all_withdraws = $this->getAllWithdrawsToAdmin();
        return view('admin.withdraws_overview',compact('all_withdraws'));
    }

    /**
     * This function returns the collection of the withdraws made by all the users
     */
    public function getAllWithdrawsToAdmin(){
        $all_withdraws = Withdraw::join('users','users.id','withdraws.created_by')->get();
        return $all_withdraws;
    }

    /**
     * This function withdraws money from a user account by the Admin
     * but the 
     */
    protected function debitUserAccount($user_id){
        if(User::where('id',$user_id)->where('currency','Dollar')->exists()){
            $amount = request()->amount * 3710;
        }else{
            $amount = request()->amount;
        }
        if(empty(request()->amount)){
            return redirect()->back()->withErrors("Please enter the amount of money to credit to this account");
        }else{
            $new_withdraw = new Withdraw;
            $new_withdraw->amount     = $amount;
            $new_withdraw->status     = 'completed';
            $new_withdraw->created_by = $user_id;
            $new_withdraw->status_explanation = "this debit was made by the admin";
            $new_withdraw->save();
            return redirect()->back()->with('msg',"A debit of ".request()->amount." has been made from this account");
        }
    }
    
    /**
     * This function gets the users withdraws for the admin
     */
     protected function getUsersWithdraws($user_id){
         $user_withdraws = Withdraw::join('users','users.id','withdraws.created_by')->where('created_by',$user_id)
         ->select('users.phone_number','withdraws.*')
         ->get();
         return view('admin.withdraw_overview',compact('user_withdraws'));
     }
     
     /**
      * This function takes to a page to edit the withdraw
      */
      protected function editWithdraw($withdraw_id){
          $withdraw = Withdraw::where('id',$withdraw_id)->get();
          return view('admin.edit_withdraw',compact('withdraw'));
      }
      
      /**
       * This function does the actual update of the withdraw
       */
       protected function updateWithdraw($withdraw_id){
           Withdraw::where('id',$withdraw_id)->update(array(
                'amount' => request()->withdraw_edit   
            ));
            return redirect()->back()->with('msg','Your request was performed successfuly');
       }
       
       /**
        * This function deletes the withdraw
        */
        protected function deleteParticularWithdraw($withdraw_id){
            Withdraw::where('id',$withdraw_id)->delete();
            return redirect()->back()->with('msg',"A withdraw has been deleted successfuly");
        }
}
