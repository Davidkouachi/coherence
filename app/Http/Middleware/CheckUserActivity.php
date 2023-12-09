<?php

// CheckUserActivity.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserActivity
{
    public function handle($request, Closure $next, $timeout = 60) // Timeout en secondes (10 minutes)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lastActivity = Session::get('lastActivity');

            if (time() - $lastActivity > $timeout) {
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('inactive', 'Votre session a expiré en raison d\'inactivité.');
            }

            Session::put('lastActivity', time());
        }

        return $next($request);
    }
}

