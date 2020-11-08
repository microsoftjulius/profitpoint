<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use App\Earnings;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->earnings_instance    = new EarningsController;
        $this->investments_instance = new InvestmentsController;
        $this->dollar_rates_instance = new DollarRatesController;
    }

    /**
     * This function gets the user profile
     */
    protected function getUserProfile(){
        if(auth()->user()->currency == "/="){
            $total_earnings         = $this->earnings_instance->getMyTotalEarnings() * $this->dollar_rates_instance->getDollarRate();
            $user_total_withdraws   = $this->earnings_instance->getMyTotalWithDraws() * $this->dollar_rates_instance->getDollarRate();
            $user_total_balance     = $this->earnings_instance->getMyTotalBalance() * $this->dollar_rates_instance->getDollarRate();
            $user_total_investments = $this->investments_instance->calculateTotalInvestmentsMadeByLoggedInUser() * $this->dollar_rates_instance->getDollarRate();
        }else{
            $total_earnings         = $this->earnings_instance->getMyTotalEarnings();
            $user_total_withdraws   = $this->earnings_instance->getMyTotalWithDraws();
            $user_total_balance     = $this->earnings_instance->getMyTotalBalance();
            $user_total_investments = $this->investments_instance->calculateTotalInvestmentsMadeByLoggedInUser();
        }
        $users_referrals  = $this->getReferralsForLoggedInUser();
        return view('admin.profile',compact('total_earnings','user_total_withdraws','user_total_balance','user_total_investments','users_referrals'));
    }

    /**
     * This function validates the users password
     */
    protected function validateUserPassword(){
        if(empty(request()->current_password)){
            return redirect()->back()->withErrors("Please enter your current password to proceed");
        }elseif(empty(request()->npassword)){
            return redirect()->back()->withErrors("Please enter the new password to proceed");
        }elseif(empty(request()->cpassword)){
            return redirect()->back()->withErrors("Please enter the new password to proceed");
        }elseif(request()->npassword != request()->cpassword){
            return redirect()->back()->withErrors("Please make sure the two passwords match");
        }elseif(Hash::check(request()->npassword, User::find(Auth::user()->id)->password)){
            return Redirect()->back()->withErrors("You can't reuse this password, kindly choose a password you haven't used before");
        }elseif(Hash::check(request()->current_password, User::find(Auth::user()->id)->password)){
            return $this->updateUserPassword();
        }else{
            return redirect()->back()->withErrors("The password you entered is wrong, enter a correct password to proceed")->withInput();
        }
        
    }

    /**
     * This function updates the user function
     */
    private function updateUserPassword(){
        $new_password = request()->npassword;
        $this->realPasswordUpdate($new_password);
        Auth::logout();
        return redirect('/login')->with('msg', 'Password was Updated successfully, kindly login now');
    }

    /**
     * This function does the real password updating
     */
    private function realPasswordUpdate($new_password){
        return User::where('id',auth()->user()->id)->update(array(
            'password' => Hash::make($new_password)
        ));
    }

    /**
     * This funtion is used by a user to upload a profile picture
     */
    protected function updateProfilePic(){
        if(!empty(request()->profile_pic)){
            $user_pic = request()->profile_pic;
            $user_pic_original_name = $user_pic->getClientOriginalName();
            $user_pic->move('profile_pics/',$user_pic_original_name);
        }else{
            return redirect()->back()->withErrors("Please attach a profile picture to update the profile");
        }
        $violated_contract = User::where('id',auth()->user()->id)->update(array(
            'profile_picture' => $user_pic_original_name
        ));
        return redirect()->back()->with('msg','Profile picture update was successful');
    }
    
    /**
     * This function gets the referrals for a user
     */
    private function getReferralsForLoggedInUser(){
        $referrals = Earnings::join('users','users.id','earnings.referral_id')->select('users.name','earnings.*','users.status')->where('earnings.sponsor_id',auth()->user()->id)->get();
        return $referrals;
    }
}
