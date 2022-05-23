<script lang="ts" setup>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { computed } from "@vue/reactivity";
import AppLayout from "../../Components/AppLayout.vue";
import CommentCard from "../../Components/CommentCard.vue";
const article = computed<App.Models.Article>(
    () => usePage().props.value.article
);
const commentForm = useForm<{ content: String | null }>({
    content: null,
});
</script>

<template>
    <AppLayout>
        <div class="article-page">
            <div class="banner">
                <div class="container">
                    <h1 v-text="article.title"></h1>

                    <div class="article-meta">
                        <Link
                            v-bind:href="
                                route('articles.show', { slug: article.slug })
                            "
                            ><img v-bind:src="article.user?.image"
                        /></Link>
                        <div class="info">
                            <a
                                v-bind:href="
                                    route('users.show', {
                                        name: article.user.name,
                                    })
                                "
                                class="author"
                                v-text="article.user?.name"
                            ></a>
                            <span
                                class="date"
                                v-text="new Date(article.created_at).toString()"
                            ></span>
                        </div>

                        <Link
                            preserve-scroll
                            as="button"
                            v-bind:href="
                                route('user-followers.store', {
                                    id: article.user_id,
                                })
                            "
                            v-bind:method="
                                article.user.is_followed ? 'delete' : 'post'
                            "
                            v-bind:class="{
                                'btn-outline-secondary':
                                    !article.user.is_followed,
                                'btn-secondary': article.user.is_followed,
                            }"
                            class="btn btn-sm"
                        >
                            <i
                                :class="
                                    article.user.is_followed
                                        ? 'ion-minus-round'
                                        : 'ion-plus-round'
                                "
                            ></i>
                            &nbsp;
                            {{
                                article.user.is_followed ? "Unfollow" : "Follow"
                            }}
                            {{ article.user?.name }}
                        </Link>
                        &nbsp;
                        <Link
                            preserve-scroll
                            as="button"
                            v-bind:method="
                                article.is_favorited ? 'DELETE' : 'POST'
                            "
                            v-bind:href="
                                route('article-favorites.store', {
                                    id: article.id,
                                })
                            "
                            v-bind:class="{
                                'btn-outline-primary': !article.is_favorited,
                                'btn-primary': article.is_favorited,
                            }"
                            class="btn btn-sm"
                        >
                            <i class="ion-heart"></i>
                            &nbsp;
                            {{
                                article.is_favorited ? "Unfavorite" : "Favorite"
                            }}
                            <span class="counter"
                                >({{ article.favoriters_count }})</span
                            >
                        </Link>
                    </div>
                </div>
            </div>

            <div class="container page">
                <div class="row article-content">
                    <div class="col-md-12" v-html="article.content_html"></div>
                </div>

                <hr />

                <div class="article-actions">
                    <div class="article-meta">
                        <Link
                            v-bind:href="
                                route('articles.show', { slug: article.slug })
                            "
                            ><img v-bind:src="article.user?.image"
                        /></Link>
                        <div class="info">
                            <a
                                v-bind:href="
                                    route('users.show', {
                                        name: article.user.name,
                                    })
                                "
                                class="author"
                                v-text="article.user?.name"
                            ></a>
                            <span
                                class="date"
                                v-text="new Date(article.created_at).toString()"
                            ></span>
                        </div>

                        <Link
                            preserve-scroll
                            as="button"
                            v-bind:href="
                                route('user-followers.store', {
                                    id: article.user_id,
                                })
                            "
                            v-bind:method="
                                article.user.is_followed ? 'delete' : 'post'
                            "
                            v-bind:class="{
                                'btn-outline-secondary':
                                    !article.user.is_followed,
                                'btn-secondary': article.user.is_followed,
                            }"
                            class="btn btn-sm"
                        >
                            <i
                                :class="
                                    article.user.is_followed
                                        ? 'ion-minus-round'
                                        : 'ion-plus-round'
                                "
                            ></i>
                            &nbsp;
                            {{
                                article.user.is_followed ? "Unfollow" : "Follow"
                            }}
                            {{ article.user?.name }}
                        </Link>
                        &nbsp;
                        <Link
                            preserve-scroll
                            as="button"
                            v-bind:method="
                                article.is_favorited ? 'DELETE' : 'POST'
                            "
                            v-bind:href="
                                route('article-favorites.store', {
                                    id: article.id,
                                })
                            "
                            v-bind:class="{
                                'btn-outline-primary': !article.is_favorited,
                                'btn-primary': article.is_favorited,
                            }"
                            class="btn btn-sm"
                        >
                            <i class="ion-heart"></i>
                            &nbsp;
                            {{
                                article.is_favorited ? "Unfavorite" : "Favorite"
                            }}
                            <span class="counter"
                                >({{ article.favoriters_count }})</span
                            >
                        </Link>
                    </div>
                </div>

                <div class="row" v-if="usePage().props.value.auth.guest">
                    <div class="col-xs-12 col-md-8 offset-md-2">
                        Please <Link href="/login">login</Link> first
                    </div>
                </div>
                <div class="row" v-if="usePage().props.value.auth.check">
                    <div class="col-xs-12 col-md-8 offset-md-2">
                        <form
                            class="card comment-form"
                            v-on:submit.prevent="
                                commentForm.post(
                                    route('articles.comments.store', {
                                        slug: article.slug,
                                    }),
                                    { onSuccess: () => commentForm.reset() }
                                )
                            "
                        >
                            <div class="card-block">
                                <textarea
                                    class="form-control"
                                    placeholder="Write a comment..."
                                    rows="3"
                                    v-model="commentForm.content"
                                ></textarea>
                                <span
                                    style="color: red"
                                    v-if="commentForm.errors.content"
                                    v-text="commentForm.errors.content"
                                ></span>
                            </div>
                            <div class="card-footer">
                                <img
                                    v-bind:src="
                                        usePage().props.value.auth.user.image
                                    "
                                    class="comment-author-img"
                                />
                                <button
                                    v-bind:disabled="commentForm.processing"
                                    class="btn btn-sm btn-primary"
                                >
                                    Post Comment
                                </button>
                            </div>
                        </form>

                        <div v-if="article.comments.length === 0">
                            No comments currently
                        </div>
                        <div v-if="article.comments.length > 0">
                            <CommentCard
                                v-for="comment in article.comments"
                                v-bind:key="comment.id"
                                v-bind:comment="comment"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
