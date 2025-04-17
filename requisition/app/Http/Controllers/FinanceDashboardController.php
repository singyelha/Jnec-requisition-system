<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Import the base Controller class you are extending
use App\Http\Controllers\Controller;
use Illuminate\View\View; // Optional: For return type hinting

class FinanceDashboardController extends Controller
{
    /**
     * Display the finance dashboard.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        
        return view('finance.dashboard');

        
    }

   
}