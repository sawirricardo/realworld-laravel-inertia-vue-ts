<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function userFollowers()
    {
        return $this->hasMany(UserFollower::class);
    }

    public function articleFavorites()
    {
        return $this->hasMany(ArticleFavorite::class);
    }

    public function favoriteArticles()
    {
        return $this->belongsToMany(Article::class, 'article_favorites');
    }

    public function scopeWithIsFollowed(Builder $query, ?User $user): Builder
    {
        return $query->when(filled($user), function (Builder $query) use ($user) {
            $query->withExists(['userFollowers AS is_followed' => function (Builder $query) use ($user) {
                $query->where('followed_by_id', $user->getKey());
            },]);
        });
    }

    public function getIsFollowedAttribute(): bool
    {
        return $this->attributes['is_followed'] ?? false;
    }
}
