<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return inertia('Session/Create');
    }

    public function store()
    {
        request()->validate([
            'email' => ['required', 'filled'],
            'password' => ['required', 'filled'],
            'remember' => ['nullable', 'boolean'],
        ]);

        throw_unless(
            Auth::attempt(request(['email', 'password']), request('remember')),
            ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ])
        );

        return redirect()->route('home');
    }

    public function destroy()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('session.create');
    }
}
