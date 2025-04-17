<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HodDashboardController extends Controller
{
    /**
     * Show the HOD dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {

        return view('hod.dashboard'); 
    }
}