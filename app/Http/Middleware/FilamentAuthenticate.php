<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as BaseAuthenticate;
use Illuminate\Http\Request;

class FilamentAuthenticate extends BaseAuthenticate
{
    /**
     * Redirect unauthenticated users to custom login page
     *
     * @param  Request  $request
     */
    protected function redirectTo($request): ?string
    {
        // Always redirect to custom login page instead of /admin/login
        return route('home');
    }
}
