<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investments;
use Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Earnings;

class ReferralsController extends Controller
{
    protected function validateReferral($sponsor_email){
        if(User::where('email',$sponsor_email)->doesntExist()){
            return redirect()->back()->withErrors("The link you provided is not valid, please use a valid link to proceed")->withInput();
        }elseif(User::where('email',request()->email)->exists()){
            return redirect()->back()->withErrors("This email is already taken, please choose another email to proceed")->withInput();
        }elseif(request()->password != request()->password_confirmation){
            return redirect()->back()->withErrors("Please make sure the two passwords match to proceed")->withInput();
        }elseif(empty(request()->country)){
            return redirect()->back()->withErrors("Please enter the country to continue")->withInput();
        }elseif(empty(request()->phone_number)){
            return redirect()->back()->withErrors("Please enter the phone number to continue")->withInput();
        }elseif(User::where('phone_number',request()->phone_number)->exists()){
            return redirect()->back()->withErrors("This number was already registered, please choose another phone number")->withInput();
        }else{
            return $this->createReferral($sponsor_email);
        }
    }
    /**
     * This function creates a referral for a user
     */
    protected function createReferral($sponsor_email){
        if(User::where('email',request()->email)->exists()){
            return redirect()->back()->withErrors("This email was already taken, kindly use another email");
        }
        User::create([
            'name'         => request()->name,
            'email'        => request()->email,
            'password'     => Hash::make(request()->password),
            'country'      => request()->country,
            'phone_number' => request()->phone_number
        ]);
        
        $refferal_id = User::where('email',request()->email)->value('id');
        $sponsor_id = User::where('email',$sponsor_email)->value('id');
        
        Earnings::create(array(
            'sponsor_id'   => $sponsor_id,
            'referral_id'  => $refferal_id
        ));
        return redirect('/overview');
    }
}
