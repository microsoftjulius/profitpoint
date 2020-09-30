<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * This function gets the company help
     */
    protected function getHelp(){
        return view('admin.help');
    }

    /**
     * This function gets the about company
     */
    protected function getCompanyProfile(){
        return view('admin.company_profile');
    }
}
