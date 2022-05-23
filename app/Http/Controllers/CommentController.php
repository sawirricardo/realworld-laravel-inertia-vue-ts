<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store($slug)
    {
        request()->validate([
            'content' => ['required', 'filled'],
        ]);

        $article = Article::where('slug', $slug)->firstOrFail();

        $article->comments()->create([
            'content' => request('content'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('articles.show', ['slug' => $article->slug]);
    }

    public function update($id)
    {
        request()->validate([
            'content' => ['required', 'filled'],
        ]);

        $comment = Comment::query()->with('user')->findOrFail($id);

        $this->authorize('update', $comment);

        $comment->update(['content' => request('content')]);

        return redirect()->route('articles.show', ['slug' => $comment->article->slug]);
    }

    public function destroy($id)
    {
        $comment = Comment::query()->with('user')->findOrFail($id);

        $this->authorize('delete', $comment);

        $comment->deleteOrFail();

        return redirect()->route('articles.show', ['slug' => $comment->article->slug]);
    }
}
