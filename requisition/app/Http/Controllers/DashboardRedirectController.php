<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log; // Use the Log facade directly

class DashboardRedirectController extends Controller
{
    /**
     * Redirect the user to the appropriate dashboard based on their user_type.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        // Use the default 'web' guard for session-based authentication
        $guard = Auth::guard('web');

        if (!$guard->check()) {
            Log::warning("Unauthenticated user attempt to access dashboard redirect.");
            return redirect()->route('login');
        }

        $user = $guard->user();
        Log::info("Dashboard Redirect: User ID {$user->id} attempting redirect.");

        if (!isset($user->user_type)) {
            Log::error("Dashboard Redirect: User ID {$user->id} missing 'user_type' property or its value is null.");

            // Log them out cleanly if their state is invalid
            $guard->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            // Return the error message shown in your screenshot
            return redirect()->route('login')->with('error', 'User account configuration issue. Please contact support.');
        }

        // *** CORRECTED ASSIGNMENT: Use 'user_type' with underscore ***
        $userType = $user->user_type;
        Log::info("Dashboard Redirect: User ID {$user->id} has user_type: {$userType}");

        // Redirect based on user_type
        switch ($userType) {
            case 0: return redirect()->route('user.dashboard'); // LRC
            case 1: return redirect()->route('hod.dashboard'); // HOD
            case 2: return redirect()->route('finance.dashboard'); // Finance
            case 3: return redirect()->route('admin.dashboard'); // President/Admin
            case 4: return redirect()->route('store.dashboard'); // Store Manager
            default:
                Log::warning("Dashboard Redirect: User ID {$user->id} has unknown user_type: {$userType}.");
                // Consider logging them out or sending to a generic error page
                return redirect('/'); // Redirect to home page as a safe default
        }
    }
}