<script lang="ts" setup>
import { usePage } from "@inertiajs/inertia-vue3";
import { defineComponent } from "vue";

const page = usePage();
</script>

<template>
    <nav class="navbar navbar-light">
        <div class="container">
            <Link class="navbar-brand" href="/">conduit</Link>
            <ul class="nav navbar-nav pull-xs-right">
                <li class="nav-item">
                    <!-- Add "active" class when you're on that page" -->
                    <Link
                        class="nav-link"
                        href="/"
                        v-bind:class="{
                            active: page.component.value == 'Home',
                        }"
                        >Home</Link
                    >
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        href="/articles/create"
                        v-if="usePage().props.value.auth.check"
                        v-bind:class="{
                            active: page.component.value == 'Article/Create',
                        }"
                    >
                        <i class="ion-compose"></i>&nbsp;New Article
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        href="/settings"
                        v-if="usePage().props.value.auth.check"
                        v-bind:class="{
                            active: page.component.value == 'User/Edit',
                        }"
                    >
                        <i class="ion-gear-a"></i>&nbsp;Settings
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        href="/login"
                        v-if="usePage().props.value.auth.guest"
                        v-bind:class="{
                            active: page.component.value == 'Session/Create',
                        }"
                        >Sign in</Link
                    >
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        href="/register"
                        v-if="usePage().props.value.auth.guest"
                        v-bind:class="{
                            active: page.component.value == 'User/Create',
                        }"
                        >Sign up</Link
                    >
                </li>
            </ul>
        </div>
    </nav>

    <slot></slot>

    <footer>
        <div class="container">
            <Link href="/" class="logo-font">conduit</Link>
            <span class="attribution">
                An interactive learning project from
                <a href="https://thinkster.io">Thinkster</a>. Code &amp; design
                licensed under MIT.
            </span>
        </div>
    </footer>
</template>
