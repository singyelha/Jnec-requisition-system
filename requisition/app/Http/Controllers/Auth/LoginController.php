<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated. Redirect to the dispatcher.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        Log::info("Login Success: User ID {$user->id} ({$user->email}) authenticated. Redirecting via dashboard route.");
        return redirect()->route('dashboard'); // Send to DashboardRedirectController
    }

    /**
     * Get the login username to be used by the controller.
     * Allows login via 'email' field.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}