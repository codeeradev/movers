<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            if (Auth::user()->status == 0) {

                // Logout using WEB guard (Sanctum safe)
                Auth::guard('web')->logout();

                // Destroy session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Your account is deactivated. Contact admin.']);
            }
        }

        return $next($request);
    }
}
