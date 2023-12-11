<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if (auth()->check()) {
                // Utilisateur connecté, redirection vers la page précédente
                return url()->previous();
            } else {
                // Utilisateur non connecté, redirection vers la page de login par défaut
                return route('login');
            }
        }
    }
}
