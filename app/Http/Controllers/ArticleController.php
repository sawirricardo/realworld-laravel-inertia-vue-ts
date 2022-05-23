<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        return inertia('Article/Index', [
            'tags' => Tag::query()
                ->get(),
            'articles' => Article::query()
                ->withCount('favoriters')
                ->with('tags')
                ->with('user')
                ->withIsFavorited(Auth::user())
                ->when(request('tag'), function (Builder $query, string $tag) {
                    return $query->whereHas('tags', function (Builder $query) use ($tag) {
                        $query->where('slug', $tag);
                    });
                })
                ->latest()
                ->paginate(),
        ]);
    }

    public function create()
    {
        return inertia('Article/Create', [
            'tags' => Tag::query()->get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'filled'],
            'content' => ['required', 'filled'],
            'excerpt' => ['nullable'],
            'tags' => ['nullable', 'array'],
        ]);

        $article = Article::create([
            'title' => request('title'),
            'content' => request('content'),
            'excerpt' => request('excerpt'),
            'user_id' => Auth::id(),
        ]);

        $tags = Tag::query()->find(request()->collect('tags')->pluck('id'));

        $article->tags()->sync($tags->modelKeys());

        return redirect()->route('articles.show', ['slug' => $article->slug]);
    }

    public function show($slug)
    {
        return inertia('Article/Show', [
            'article' => Article::query()
                ->with('tags')
                ->with('user', function (BelongsTo|User $query) {
                    $query->withIsFollowed(Auth::user())
                        ->withCount('articleFavorites')
                        ->withCount('userFollowers');
                })
                ->withIsFavorited(Auth::user())
                ->withCount('favoriters')
                ->with(['comments' => function (HasMany $query) {
                    $query
                        ->with('user')
                        ->latest();
                },])
                ->where('slug', $slug)
                ->firstOrFail(),
        ]);
    }

    public function edit($slug)
    {
        return inertia('Article/Edit', [
            'tags' => Tag::query()->get(),
            'article' => Article::query()
                ->where('slug', $slug)
                ->whereBelongsTo(Auth::user())
                ->firstOrFail(),
        ]);
    }

    public function update($slug)
    {
        request()->validate([
            'title' => ['required', 'filled'],
            'content' => ['required', 'filled'],
            'excerpt' => ['nullable'],
            'tags' => ['nullable', 'array'],
        ]);

        $article = Article::query()
            ->where('slug', $slug)
            ->whereBelongsTo(Auth::user())
            ->firstOrFail();

        $this->authorize('update', $article);

        $article->update([
            'title' => request('title'),
            'content' => request('content'),
            'excerpt' => request('excerpt'),
        ]);

        return redirect()->route('articles.show', ['slug' => $article->slug]);
    }

    public function destroy($slug)
    {
        $article = Article::query()->where('slug', $slug)->whereBelongsTo(Auth::user())->firstOrFail();

        $this->authorize('delete', $article);

        $article->deleteOrFail();

        return redirect()->route('articles.index');
    }
}
