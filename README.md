> ### Laravel Inertia Vue Typescript codebase containing real world examples (CRUD, auth, advanced patterns, etc) that adheres to the [RealWorld](https://github.com/gothinkster/realworld) spec and API.

### [Demo](https://github.com/sawirricardo/realworld-laravel-inertia-vue-ts)&nbsp;&nbsp;&nbsp;&nbsp;[Github](https://realworld-laravel-inertiavuets.herokuapp.com/)

> (Thanks to [Conwnet](https://github.com/conwnet/github1s))

This codebase was created to demonstrate a fully fledged fullstack application built with **Laravel Inertia Vue Typescript** including CRUD operations, authentication, routing, pagination, and more.

We've gone to great lengths to adhere to the **Laravel Inertia Vue Typescript** community styleguides & best practices.

For more information on how to this works with other frontends/backends, head over to the [RealWorld](https://github.com/gothinkster/realworld) repo.

## Project Overview

"Conduit" is a social blogging site (i.e. a Medium.com clone). It uses a custom API for all requests, including authentication. You can view a live demo over at https://realworld-laravel-inertia-vue.herokuapp.com

**General functionality:**

-   Authenticate users via JWT (login/signup pages + logout button on settings page)
-   CRU\* users (sign up & settings page - no deleting required)
-   CRUD Articles
-   CR\*D Comments on articles (no updating required)
-   GET and display paginated lists of articles
-   Favorite articles
-   Follow other users

### Routing Guidelines

-   Home page (URL: / )
    -   List of tags
    -   List of articles pulled from either Feed, Global, or by Tag
    -   Pagination for list of articles
-   Sign in/Sign up pages (URL: /login, /register )
-   Settings page (URL: /settings )
-   Editor page to create/edit articles (URL: /editor, /editor/article-slug-here )
-   Article page (URL: /article/article-slug-here )
    -   Delete article button (only shown to article's author)
    -   Render markdown from server client side
    -   Comments section at bottom of page
    -   Delete comment button (only shown to comment's author)
-   Profile page (URL: /profile/:username, /profile/:username/favorites )
    -   Show basic user info
    -   List of articles populated from author's created articles or author's favorited articles

# How it works

You can also access the back-end to the /api route.

# Installation

```
1. git clone https://github.com/sawirricardo/realworld-laravel-inertia-vue.git
2. cd realworld-laravel-inertia-vue
3. composer install
4. npm install
5. npm run watch
6. php artisan serve (or use Laravel Valet)
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
