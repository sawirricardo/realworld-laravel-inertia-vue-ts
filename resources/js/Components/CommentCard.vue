<script lang="ts" setup>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps<{
    comment: App.Models.Comment;
}>();

const authUser: App.Models.User | null | undefined =
    usePage().props.value.auth?.user;

const updatingComment = ref(false);

const commentForm = useForm<{ content: string | null }>({
    content: props.comment.content,
});
</script>

<template>
    <div class="card">
        <div class="card-block">
            <textarea
                class="form-control"
                placeholder="Write a comment..."
                rows="3"
                v-if="updatingComment"
                v-model="commentForm.content"
            ></textarea>
            <p
                class="card-text"
                v-text="comment.content"
                v-if="!updatingComment"
            ></p>
        </div>
        <div class="card-footer">
            <Link
                v-bind:href="route('users.show', { name: comment.user.name })"
                class="comment-author"
            >
                <img
                    v-bind:src="comment.user.image"
                    class="comment-author-img"
                />
            </Link>
            &nbsp;
            <Link
                v-bind:href="route('users.show', { name: comment.user?.name })"
                class="comment-author"
                v-text="comment.user.name"
            ></Link>
            <span
                class="date-posted"
                v-text="new Date(comment.created_at).toString()"
            ></span>
            <span class="mod-options" v-if="authUser?.id == comment?.user_id">
                <button
                    v-if="updatingComment"
                    v-on:click="updatingComment = false"
                >
                    Cancel
                </button>
                <button
                    v-if="updatingComment"
                    v-bind:disabled="commentForm.processing"
                    v-on:click="
                        commentForm.put(
                            route('comments.update', { id: comment.id }),
                            {
                                onSuccess: () => {
                                    commentForm.defaults(
                                        'content',
                                        comment.content
                                    );
                                    commentForm.reset();
                                    updatingComment = false;
                                },
                                preserveScroll: true,
                            }
                        )
                    "
                >
                    Save
                </button>
                <i
                    class="ion-edit"
                    v-if="!updatingComment"
                    v-on:click="updatingComment = true"
                    v-bind:disabled="commentForm.processing"
                ></i>
                <Link
                    v-if="!updatingComment"
                    as="button"
                    method="delete"
                    v-bind:href="route('comments.destroy', { id: comment.id })"
                    v-bind:disabled="commentForm.processing"
                >
                    <i class="ion-trash-a"></i>
                </Link>
            </span>
        </div>
    </div>
</template>
