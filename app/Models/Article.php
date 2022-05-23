<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use HasFactory;
    use HasSlug;

    protected $appends = [
        'content_html',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    public function favoriters()
    {
        return $this->belongsToMany(User::class, 'article_favorites');
    }

    public function scopeWithIsFavorited(Builder $query, ?User $user): Builder
    {
        return $query->when(filled($user), function (Builder $query) use ($user) {
            $query->withExists(['favoriters AS is_favorited' => function (Builder $query) use ($user) {
                $query->where('user_id', $user?->getKey());
            },]);
        });
    }

    public function getIsFavoritedAttribute(): bool
    {
        return $this->attributes['is_favorited'] ?? false;
    }

    public function getContentHtmlAttribute(): ?string
    {
        return blank($this->content) ? null : str($this->content)->markdown();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
