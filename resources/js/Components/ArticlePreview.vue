<script lang="ts" setup>
defineProps<{
    article: App.Models.Article;
    canFavorite: boolean;
}>();
</script>

<template>
    <div class="article-preview">
        <div class="article-meta">
            <Link
                v-bind:href="route('users.show', { name: article?.user?.name })"
            >
                <img v-bind:src="article.user?.image" />
            </Link>
            <div class="info">
                <Link
                    v-bind:href="
                        route('users.show', { name: article?.user?.name })
                    "
                    class="author"
                    v-text="article.user?.name"
                ></Link>
                <span
                    class="date"
                    v-text="new Date(article.created_at).toString()"
                ></span>
            </div>
            <Link
                preserve-scroll
                as="button"
                v-bind:method="article.is_favorited ? 'DELETE' : 'POST'"
                v-bind:href="
                    route('article-favorites.store', { id: article?.id })
                "
                v-bind:class="{
                    'btn-outline-primary': !article.is_favorited,
                    'btn-primary': article.is_favorited,
                }"
                class="btn btn-sm pull-xs-right"
            >
                <i class="ion-heart"></i>
                {{ article?.favoriters_count }}
            </Link>
        </div>
        <a
            v-bind:href="route('articles.show', { slug: article?.slug })"
            class="preview-link"
        >
            <h1 v-text="article?.title"></h1>
            <p v-text="article?.excerpt"></p>
            <span>Read more...</span>
            <ul class="tag-list" v-if="article?.tags?.length > 0">
                <li
                    v-for="tag in article.tags"
                    v-bind:key="tag.id"
                    v-text="tag.name"
                    class="tag-default tag-pill tag-outline"
                ></li>
            </ul>
        </a>
    </div>
</template>
