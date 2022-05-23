<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        return inertia('Home', [
            'tags' => Tag::query()
                ->get(),
            'articles' => Article::query()
                ->withCount('favoriters')
                ->with('tags')
                ->with('user')
                ->withIsFavorited(Auth::user())
                ->latest()
                ->paginate(),
            'feed' => fn () => Article::query()
                ->withCount('favoriters')
                ->with('tags')
                ->with('user')
                ->withIsFavorited(Auth::user())
                ->whereHas('user.userFollowers', function (Builder $query) {
                    $query->where('followed_by_id', Auth::id());
                })
                ->latest()
                ->paginate(),
        ]);
    }
}
