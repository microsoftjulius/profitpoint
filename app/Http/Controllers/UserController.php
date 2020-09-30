<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Earnings;
use App\Withdraws as Withdraw;
use App\Investments;

class UserController extends Controller
{
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
}
