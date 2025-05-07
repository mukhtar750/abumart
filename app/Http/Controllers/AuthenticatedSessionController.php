<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Destroy an authenticated session (Logout).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Debugging log
        Log::info('Logout request received for user: ', ['user_id' => Auth::id()]);

        // Ensure the user is logged out before invalidating the session
        Auth::logout();

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Debugging log to confirm session is cleared
        Log::info('User logged out successfully.');

        return redirect()->route('login')->with('status', 'You have been logged out.');
    }
}
