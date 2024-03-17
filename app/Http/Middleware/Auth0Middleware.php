<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth0\SDK\Auth0;
use Symfony\Component\HttpFoundation\Response;

class Auth0Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth0 = new Auth0([
            'domain' => env('AUTH0_DOMAIN'),
            'client_id' => env('AUTH0_CLIENT_ID'),
            'client_secret' => env('AUTH0_CLIENT_SECRET'),
            'redirect_uri' => env('AUTH0_CALLBACK_URL'),
            'audience' => 'https://your-auth0-domain.auth0.com/api/v2/',
            'scope' => 'openid profile email',
        ]);

        $auth0->login();

        return $next($request);
    }
}
