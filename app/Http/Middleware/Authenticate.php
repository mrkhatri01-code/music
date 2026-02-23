<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            $host = $request->getHost();
            if ($host === 'artists.nepa-ly.com') {
                return route('artist.login');
            }
            if ($host === 'admin.nepa-ly.com') {
                return route('admin.login');
            }
            return route('login');
        }
        return null;
    }
}
