<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserActivity
{
    public function handle($request, Closure $next)
    {
        $userLastActivity = Session::get('last_activity');

        if ($userLastActivity && time() - $userLastActivity > 120) { // 120 seconds = 2 minutes
            // L'utilisateur est inactif, rediriger vers la page de connexion
            Auth::logout();
            return redirect('/login')->with('message', 'Votre session a expiré en raison d\'une inactivité.');
        }

        Session::put('last_activity', time());

        return $next($request);
    }
}
