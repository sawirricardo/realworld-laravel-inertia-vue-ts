<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return inertia('User/Create');
    }

    public function store()
    {
        request()->validate([
            'name' => ['required', 'filled'],
            'email' => ['required', 'filled', 'email', 'unique:users'],
            'password' => ['required', 'filled', 'confirmed'],
        ]);

        Auth::login(
            User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
            ])
        );

        return redirect()->route('home');
    }

    public function show($name)
    {
        $user = User::query()->withIsFollowed(Auth::user())->whereName($name)->firstOrFail();
        return inertia('User/Show', [
            'user' => $user,
            'articles' => Article::query()
                ->whereBelongsTo($user)
                ->with('user')
                ->with('tags')
                ->withCount('favoriters')
                ->withIsFavorited(Auth::user())
                ->paginate(),
            'favoritedArticles' => Article::query()
                ->whereHas('favoriters', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->getKey());
                })
                ->with('user')
                ->with('tags')
                ->withCount('favoriters')
                ->withIsFavorited(Auth::user())
                ->paginate(),
        ]);
    }

    public function edit()
    {
        return inertia('User/Edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update()
    {
        request()->validate([
            'name' => ['required', 'filled'],
            'bio' => ['nullable', 'filled'],
            'image' => ['nullable', 'filled', 'url'],
            'email' => ['required', 'filled',
                Rule::unique('users', 'email')->ignore(Auth::user()->getKey()),
            ],
            'password' => ['nullable', 'confirmed'],
        ]);

        $this->authorize('update', Auth::user());

        Auth::user()->update([
            'name' => request('name'),
            'email' => request('email'),
            'bio' => request('bio'),
            'image' => request('image'),
        ]);

        return redirect()->route('home');
    }

    public function destroy()
    {
        $user = Auth::user();

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $user->deleteOrFail();
        return redirect()->route('user.create');
    }
}
