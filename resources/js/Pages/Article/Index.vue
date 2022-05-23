<script lang="ts" setup>
import { usePage } from "@inertiajs/inertia-vue3";
import { defineComponent } from "vue";
import ArticlePreview from "../../Components/ArticlePreview.vue";
import AppLayout from "../../Components/AppLayout.vue";
const { props } = usePage();
const articles: App.Models.Article[] = props.value.articles;
const tags: App.Models.Tag[] = props.value.tags;
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
                                    <a class="nav-link disabled" href=""
                                        >Your Feed</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href=""
                                        >Global Feed</a
                                    >
                                </li>
                            </ul>
                        </div>

                        <div v-if="articles.length === 0">No Articles</div>
                        <div v-if="articles.length > 0">
                            <ArticlePreview
                                v-for="article in articles"
                                v-bind:key="article.id"
                                v-bind:article="article"
                            />
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
