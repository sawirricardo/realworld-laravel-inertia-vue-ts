<script lang="ts" setup>
import AppLayout from "../../Components/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const registerForm = useForm<{
    name: string | null;
    email: string | null;
    password: string | null;
    password_confirmation: string | null;
}>({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});
</script>

<template>
    <AppLayout>
        <div class="auth-page">
            <div class="container page">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-xs-12">
                        <h1 class="text-xs-center">Sign up</h1>
                        <p class="text-xs-center">
                            <Link href="/login">Have an account?</Link>
                        </p>

                        <form v-on:submit.prevent="registerForm.post('/users')">
                            <fieldset class="form-group">
                                <input
                                    class="form-control form-control-lg"
                                    type="text"
                                    placeholder="Your Name"
                                    v-model="registerForm.name"
                                />
                                <ul
                                    class="error-messages"
                                    v-if="registerForm.errors.name"
                                >
                                    <li v-text="registerForm.errors.name"></li>
                                </ul>
                            </fieldset>
                            <fieldset class="form-group">
                                <input
                                    class="form-control form-control-lg"
                                    type="text"
                                    placeholder="Email"
                                    v-model="registerForm.email"
                                />
                                <ul
                                    class="error-messages"
                                    v-if="registerForm.errors.email"
                                >
                                    <li v-text="registerForm.errors.email"></li>
                                </ul>
                            </fieldset>
                            <fieldset class="form-group">
                                <input
                                    class="form-control form-control-lg"
                                    type="password"
                                    placeholder="Password"
                                    v-model="registerForm.password"
                                />
                                <ul
                                    class="error-messages"
                                    v-if="registerForm.errors.password"
                                >
                                    <li
                                        v-text="registerForm.errors.password"
                                    ></li>
                                </ul>
                            </fieldset>
                            <fieldset class="form-group">
                                <input
                                    class="form-control form-control-lg"
                                    type="password"
                                    placeholder="Password Confirmation"
                                    v-model="registerForm.password_confirmation"
                                />
                                <ul
                                    class="error-messages"
                                    v-if="
                                        registerForm.errors
                                            .password_confirmation
                                    "
                                >
                                    <li
                                        v-text="
                                            registerForm.errors
                                                .password_confirmation
                                        "
                                    ></li>
                                </ul>
                            </fieldset>
                            <button
                                class="btn btn-lg btn-primary pull-xs-right"
                            >
                                Sign up
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
