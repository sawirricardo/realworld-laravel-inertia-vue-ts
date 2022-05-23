/**
 * This file is auto generated using 'php artisan typescript:generate'
 *
 * Changes to this file will be lost when the command is run again
 */

declare namespace App.Models {
    export interface UserFollower {
        id: number;
        user_id: number | null;
        followed_by_id: number | null;
        user?: App.Models.User | null;
        followed_by?: App.Models.User | null;
    }

    export interface Tag {
        id: number;
        name: string;
        slug: string | null;
        created_at: string | null;
        updated_at: string | null;
        articles?: Array<App.Models.Article> | null;
        articles_count?: number | null;
    }

    export interface User {
        id: number;
        name: string;
        email: string;
        email_verified_at: string | null;
        password: string;
        remember_token: string | null;
        created_at: string | null;
        updated_at: string | null;
        image: string | null;
        bio: string | null;
        articles?: Array<App.Models.Article> | null;
        comments?: Array<App.Models.Comment> | null;
        user_followers?: Array<App.Models.UserFollower> | null;
        article_favorites?: Array<App.Models.ArticleFavorite> | null;
        favorite_articles?: Array<App.Models.Article> | null;
        articles_count?: number | null;
        comments_count?: number | null;
        user_followers_count?: number | null;
        article_favorites_count?: number | null;
        favorite_articles_count?: number | null;
        readonly is_followed?: boolean;
    }

    export interface Comment {
        id: number;
        content: string | null;
        article_id: number | null;
        user_id: number | null;
        created_at: string | null;
        updated_at: string | null;
        user?: App.Models.User | null;
        article?: App.Models.Article | null;
    }

    export interface ArticleTag {
        id: number;
        article_id: number | null;
        tag_id: number | null;
        article?: App.Models.Article | null;
        tag?: App.Models.Tag | null;
    }

    export interface ArticleFavorite {
        id: number;
        article_id: number | null;
        user_id: number | null;
        user?: App.Models.User | null;
        article?: App.Models.Article | null;
    }

    export interface Article {
        id: number;
        title: string;
        slug: string | null;
        content: string | null;
        excerpt: string | null;
        user_id: number | null;
        created_at: string | null;
        updated_at: string | null;
        user?: App.Models.User | null;
        comments?: Array<App.Models.Comment> | null;
        tags?: Array<App.Models.Tag> | null;
        favoriters?: Array<App.Models.User> | null;
        comments_count?: number | null;
        tags_count?: number | null;
        favoriters_count?: number | null;
        readonly is_favorited?: boolean;
        readonly content_html?: string | null;
    }

}
