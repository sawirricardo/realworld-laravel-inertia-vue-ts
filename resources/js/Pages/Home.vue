<script lang="ts" setup>
import { usePage } from "@inertiajs/inertia-vue3";
import { defineComponent, watch, ref } from "vue";
import ArticlePreview from "../Components/ArticlePreview.vue";
import AppLayout from "../Components/AppLayout.vue";
import { computed } from "@vue/reactivity";
import { Inertia } from "@inertiajs/inertia";
import Pagination from "../Components/Pagination.vue";

const isShowingFeed = ref(false);
watch(isShowingFeed, () => {
    if (isShowingFeed.value) {
        Inertia.reload({ only: ["feed"] });
    }
});
const auth = computed(() => usePage().props.value.auth);

const articles = computed(() => usePage().props.value.articles);
const tags = computed<App.Models.Tag[]>(() => usePage().props.value.tags);
const feed = computed(() => usePage().props.value.feed);
</script>

<template>
    <AppLayout>
        <div class="home-page">
            <div class="banner">
                <div class="container">
                    <h1 class="logo-font">conduit</h1>
                    <p>A place to share your knowledge.</p>
                </div>
            </div>

            <div class="container page">
                <div class="row">
                    <div class="col-md-9">
                        <div class="feed-toggle">
                            <ul class="nav nav-pills outline-active">
                                <li class="nav-item">
                                    <button
                                        class="nav-link"
                                        v-bind:class="{
                                            disabled:
                                                usePage().props.value.auth
                                                    .guest,
                                            active: isShowingFeed,
                                        }"
                                        v-bind:disabled="
                                            usePage().props.value.auth.guest
                                        "
                                        v-on:click="isShowingFeed = true"
                                    >
                                        Your Feed
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <Link
                                        v-bind:class="{
                                            active: !isShowingFeed,
                                        }"
                                        class="nav-link"
                                        href="/"
                                        >Global Feed</Link
                                    >
                                </li>
                            </ul>
                        </div>

                        <div v-if="isShowingFeed">
                            <div v-if="articles.data.length === 0">
                                No Articles
                            </div>
                            <div v-if="articles.data.length > 0">
                                My Feed
                                <ArticlePreview
                                    v-for="article in feed.data"
                                    v-bind:key="article.id"
                                    v-bind:article="article"
                                />
                                <Pagination v-bind:links="feed.links" />
                            </div>
                        </div>
                        <div v-if="!isShowingFeed">
                            <div v-if="articles.data.length === 0">
                                No Articles
                            </div>
                            <div v-if="articles.data.length > 0">
                                <ArticlePreview
                                    v-for="article in articles.data"
                                    v-bind:key="article.id"
                                    v-bind:article="article"
                                />
                                <Pagination v-bind:links="articles.links" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="sidebar">
                            <p>Popular Tags</p>

                            <div class="tag-list">
                                <a
                                    v-for="tag in tags"
                                    v-bind:key="tag.id"
                                    v-text="tag.name"
                                    v-bind:href="
                                        route('articles.index', {
                                            tag: tag.name,
                                        })
                                    "
                                    class="tag-pill tag-default"
                                ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
