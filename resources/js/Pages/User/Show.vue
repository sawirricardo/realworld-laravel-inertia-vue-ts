<script lang="ts" setup>
import { usePage } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import ArticlePreview from "../../Components/ArticlePreview.vue";
import AppLayout from "../../Components/AppLayout.vue";
import { computed } from "@vue/reactivity";
import Pagination from "../../Components/Pagination.vue";

const isShowingFavorites = ref(false);
const user = computed<App.Models.User>(() => usePage().props.value.user);
const articles = computed(() => usePage().props.value.articles);
const favoriteArticles = computed(() => usePage().props.value.favoriteArticles);
</script>

<template>
    <AppLayout>
        <div class="profile-page">
            <div class="user-info">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-10 offset-md-1">
                            <img v-bind:src="user.image" class="user-img" />
                            <h4 v-text="user.name"></h4>
                            <p v-text="user.bio"></p>
                            <Link
                                preserve-scroll
                                as="button"
                                v-if="
                                    usePage().props.value.auth.user.id !=
                                    user.id
                                "
                                v-bind:href="
                                    route('user-followers.store', {
                                        id: user.id,
                                    })
                                "
                                v-bind:method="
                                    user.is_followed ? 'delete' : 'post'
                                "
                                v-bind:class="{
                                    'btn-outline-secondary': !user.is_followed,
                                    'btn-secondary': user.is_followed,
                                }"
                                class="btn btn-sm action-btn"
                            >
                                <i
                                    :class="
                                        user.is_followed
                                            ? 'ion-minus-round'
                                            : 'ion-plus-round'
                                    "
                                ></i>
                                &nbsp;
                                {{ user.is_followed ? "Unfollow" : "Follow" }}
                                {{ user?.name }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 offset-md-1">
                        <div class="articles-toggle">
                            <ul class="nav nav-pills outline-active">
                                <li class="nav-item">
                                    <button
                                        class="nav-link"
                                        v-bind:class="{
                                            active: !isShowingFavorites,
                                        }"
                                        v-on:click="isShowingFavorites = false"
                                    >
                                        My Articles
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button
                                        class="nav-link"
                                        v-bind:class="{
                                            active: isShowingFavorites,
                                        }"
                                        v-on:click="isShowingFavorites = true"
                                    >
                                        Favorited Articles
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div
                            v-if="
                                isShowingFavorites
                                    ? favoriteArticles.data.length === 0
                                    : articles.data.length === 0
                            "
                        >
                            No Articles
                        </div>
                        <div
                            v-if="
                                isShowingFavorites
                                    ? favoriteArticles.data.length > 0
                                    : articles.data.length > 0
                            "
                        >
                            <ArticlePreview
                                v-for="article in isShowingFavorites
                                    ? favoriteArticles.data
                                    : articles.data"
                                v-bind:key="article.id"
                                v-bind:article="article"
                            />
                            <Pagination
                                v-bind:links="
                                    isShowingFavorites
                                        ? favoriteArticles.links
                                        : articles.links
                                "
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
