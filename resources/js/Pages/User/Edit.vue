<script lang="ts" setup>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import AppLayout from "../../Components/AppLayout.vue";

const userForm = useForm<{
    name: string | null;
    email: string | null;
    password: string | null;
    password_confirmation: string | null;
    bio: string | null;
    image: string | null;
}>({
    name: usePage().props.value.auth.user.name,
    email: usePage().props.value.auth.user.email,
    image: usePage().props.value.auth.user.image,
    bio: usePage().props.value.auth.user.bio,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <AppLayout>
        <div class="settings-page">
            <div class="container page">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-xs-12">
                        <h1 class="text-xs-center">Your Settings</h1>

                        <form v-on:submit.prevent="userForm.put('/settings')">
                            <fieldset>
                                <fieldset class="form-group">
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="URL of profile picture"
                                        v-model="userForm.image"
                                    />
                                    <ul
                                        class="error-messages"
                                        v-if="userForm.errors.image"
                                    >
                                        <li v-text="userForm.errors.image"></li>
                                    </ul>
                                </fieldset>
                                <fieldset class="form-group">
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        placeholder="Your Name"
                                        v-model="userForm.name"
                                    />
                                    <ul
                                        class="error-messages"
                                        v-if="userForm.errors.name"
                                    >
                                        <li v-text="userForm.errors.name"></li>
                                    </ul>
                                </fieldset>
                                <fieldset class="form-group">
                                    <textarea
                                        class="form-control form-control-lg"
                                        rows="8"
                                        placeholder="Short bio about you"
                                        v-model="userForm.bio"
                                    ></textarea>
                                    <ul
                                        class="error-messages"
                                        v-if="userForm.errors.bio"
                                    >
                                        <li v-text="userForm.errors.bio"></li>
                                    </ul>
                                </fieldset>
                                <fieldset class="form-group">
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        placeholder="Email"
                                        v-model="userForm.email"
                                    />
                                    <ul
                                        class="error-messages"
                                        v-if="userForm.errors.email"
                                    >
                                        <li v-text="userForm.errors.email"></li>
                                    </ul>
                                </fieldset>
                                <fieldset class="form-group">
                                    <input
                                        class="form-control form-control-lg"
                                        type="password"
                                        placeholder="Password"
                                        v-model="userForm.password"
                                    />
                                    <ul
                                        class="error-messages"
                                        v-if="userForm.errors.password"
                                    >
                                        <li
                                            v-text="userForm.errors.password"
                                        ></li>
                                    </ul>
                                </fieldset>
                                <fieldset class="form-group">
                                    <input
                                        class="form-control form-control-lg"
                                        type="password"
                                        placeholder="Password Confirmation (if you change it)"
                                        v-model="userForm.password_confirmation"
                                    />
                                    <ul
                                        class="error-messages"
                                        v-if="
                                            userForm.errors
                                                .password_confirmation
                                        "
                                    >
                                        <li
                                            v-text="
                                                userForm.errors
                                                    .password_confirmation
                                            "
                                        ></li>
                                    </ul>
                                </fieldset>
                                <button
                                    class="btn btn-lg btn-primary pull-xs-right"
                                >
                                    Update Settings
                                </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
