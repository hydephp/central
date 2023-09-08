<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GuestableAuthenticate extends \Filament\Http\Middleware\Authenticate
{
    protected function unauthenticated($request, array $guards): void
    {
        Auth::login(User::guest());
    }
}
