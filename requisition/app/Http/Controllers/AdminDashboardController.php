<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('admin.admin_dashboard');
    }
}