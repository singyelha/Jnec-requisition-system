<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * Display the user-specific dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        if(Auth::id()){
            if(Auth::user()->usertype=='0'){
                return view('dashboard');
            }
            else{
                return view('hod-dashboard');
            }
        }
    }
}