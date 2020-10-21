<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Earnings;
use App\Withdraws as Withdraw;
use App\Investments;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * This function gets all the users in the system
     */
    protected function getAllUsers(){
        $all_users = User::where('id','!=',auth()->user()->id)->get();
        return view('admin.all_users',compact('all_users'));
    }

    /**
     * This function gets the profile of a User by admin
     */
    protected function viewUserProfile($id){
        $user_profile = User::where('id',$id)->get();
        $total_earnings = Earnings::where('sponsor_id',$id)->sum('amount');
        $user_total_withdraws = Withdraw::where('created_by',$id)->sum('amount');
        $user_total_investments = Investments::where('created_by',$id)->sum('amount');
        return view('admin.user_profile_view',compact('user_profile','total_earnings','user_total_withdraws','user_total_investments'));
    }
    
    /**
     * This function updates the currency of the User to Dollar or Ugx
     */
    protected function updateUserCurrency($id){
        User::where('id',$id)->update(array(
            'currency' => request()->currency
        ));
        return redirect()->back()->with('msg','You successfuly converted your currency to '. request()->currency);
    }
    
    /**
     * This function updates the user status to suspended
     */
     protected function suspendUser($user_id){
        User::where('id',$user_id)->update(array(
            'status' => 'suspended'    
        ));
        return redirect()->back()->with('msg', 'You successfully suspended a user');
     }
     
     /**
      * this function updates the user status to active, the user whose account was deleted
      */
      protected function activateUser($user_id){
          User::where('id',$user_id)->update(array(
              'status' => 'active'
            ));
            return redirect()->back()->with('msg', 'You successfully activated a user');
      }
      
      /**
         * This function edits the user phone number
         */
         protected function editUserPhoneNumber($user_id){
             User::where('id',$user_id)->update(array(
                'phone_number' => request()->phone_number     
            ));
            return redirect()->back()->with('msg','New User Phone number has been updated successfully');
         }
}