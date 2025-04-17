<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// You need to import the base Controller class if you are extending it
use App\Http\Controllers\Controller;
use Illuminate\View\View; // Optional, but good practice for type hinting

class StoreDashboardController extends Controller
{
    /**
     * Display the store dashboard.
     *
     * @param Request $request // You might need the request later
     * @return View // Type hint the return type
     */
    public function index(Request $request): View
    {
        // The logic to return the view goes inside a method
        return view('superadmin.dashboard');
    }
}