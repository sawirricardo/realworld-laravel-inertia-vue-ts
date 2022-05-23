<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $tags = Tag::factory(30)->create();

        \App\Models\User::factory(10)
            ->has(
                Article::factory(10)
                    ->has(Comment::factory(10))
            )
            ->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Article::query()->get()->each(function (Article $article) {
            $article->tags()->sync(Tag::query()->inRandomOrder()->take(3)->pluck('id'));
        });
    }
}
