<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],

            'role' => [
                'required',
                'in:admin,owner,agent,user,buyer'
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Spatie role assign
        $user->assignRole($request->role);

        event(new Registered($user));

        Auth::login($user);

        // Role ke according dashboard
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
         if ($user->hasRole('buyer')) {
            return redirect()->route('buyer.dashboard');
        }

        if ($user->hasRole('owner')) {
            return redirect()->route('owner.dashboard');
        }

        if ($user->hasRole('agent')) {
            return redirect()->route('agent.dashboard');
        }

        return redirect()->route('dashboard');
    }
}