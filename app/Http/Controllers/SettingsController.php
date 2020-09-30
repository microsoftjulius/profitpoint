<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * This function returns the settings page
     */
    protected function getSettingsPage(){
        return view('admin.settings');
    }
}
