<script lang="ts" setup>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import AppLayout from "../../Components/AppLayout.vue";
import VueMultiselect from "vue-multiselect";
const articleForm = useForm<{
    title: string | null;
    content: string | null;
    excerpt: string | null;
    tags: App.Models.Tag[] | null;
}>({
    title: null,
    content: null,
    excerpt: null,
    tags: null,
});
const tags = usePage().props.value.tags;
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <AppLayout>
        <div class="editor-page">
            <div class="container page">
                <div class="row">
                    <div class="col-md-10 offset-md-1 col-xs-12">
                        <form
                            v-on:submit.prevent="articleForm.post('/articles')"
                        >
                            <fieldset>
                                <fieldset class="form-group">
                                    <input
                                        type="text"
                                        class="form-control form-control-lg"
                                        placeholder="Article Title"
                                        v-model="articleForm.title"
                                    />
                                </fieldset>
                                <fieldset class="form-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="What's this article about?"
                                        v-model="articleForm.excerpt"
                                    />
                                </fieldset>
                                <fieldset class="form-group">
                                    <textarea
                                        class="form-control"
                                        rows="8"
                                        placeholder="Write your article (in markdown)"
                                        v-model="articleForm.content"
                                    ></textarea>
                                </fieldset>
                                <fieldset class="form-group">
                                    <VueMultiselect
                                        class="form-control"
                                        placeholder="Enter tags (seperate by comma)"
                                        v-model="articleForm.tags"
                                        v-bind:options="tags"
                                        v-bind:multiple="true"
                                        label="name"
                                        track-by="id"
                                    ></VueMultiselect>
                                    <!-- <div class="tag-list">

                                    </div> -->
                                </fieldset>
                                <button
                                    class="btn btn-lg pull-xs-right btn-primary"
                                >
                                    Publish Article
                                </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
