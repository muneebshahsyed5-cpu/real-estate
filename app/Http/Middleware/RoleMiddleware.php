<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // User login nahi hai
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Admin
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Owner
        if ($user->hasRole('owner')) {
            return redirect()->route('owner.dashboard');
        }

        // Agent
        if ($user->hasRole('agent')) {
            return redirect()->route('agent.dashboard');
        }

        // Buyer
        if ($user->hasRole('buyer')) {
            return redirect()->route('buyer.dashboard');
        }

        // Normal User
        if ($user->hasRole('user')) {
            return redirect()->route('user.dashboard');
        }

        // Role nahi mila
        Auth::logout();

        return redirect()->route('login');
    }
}
