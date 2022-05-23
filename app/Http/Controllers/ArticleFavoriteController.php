<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleFavorite;
use Illuminate\Support\Facades\Auth;

class ArticleFavoriteController extends Controller
{
    public function store($id)
    {
        $article = Article::findOrFail($id);

        $this->authorize('create', [ArticleFavorite::class, $article]);

        ArticleFavorite::firstOrCreate([
            'user_id' => Auth::id(),
            'article_id' => $article->getKey(),
        ]);

        return back();
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $favorite = ArticleFavorite::query()
            ->where('user_id', Auth::id())
            ->where('article_id', $article->getKey())
            ->firstOrFail();

        $this->authorize('delete', $favorite);

        $favorite->delete();

        return back();
    }
}
