<script lang="ts" setup>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "../../Components/AppLayout.vue";

const loginForm = useForm<{
    email: String | null;
    password: String | null;
}>({
    email: null,
    password: null,
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
                            <Link href="/register">Don't have an account?</Link>
                        </p>

                        <form v-on:submit.prevent="loginForm.post('/login')">
                            <fieldset class="form-group">
                                <input
                                    class="form-control form-control-lg"
                                    type="text"
                                    placeholder="Email"
                                    v-model="loginForm.email"
                                />
                                <ul
                                    class="error-messages"
                                    v-if="loginForm.errors.email"
                                >
                                    <li v-text="loginForm.errors.email"></li>
                                </ul>
                            </fieldset>
                            <fieldset class="form-group">
                                <input
                                    class="form-control form-control-lg"
                                    type="password"
                                    placeholder="Password"
                                    v-model="loginForm.password"
                                />
                                <ul
                                    class="error-messages"
                                    v-if="loginForm.errors.password"
                                >
                                    <li v-text="loginForm.errors.password"></li>
                                </ul>
                            </fieldset>
                            <button
                                class="btn btn-lg btn-primary pull-xs-right"
                            >
                                Sign in
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
