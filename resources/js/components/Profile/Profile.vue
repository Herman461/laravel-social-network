<template>

        <div class="bg-black min-h-full min-h-screen">
            <base-header />

            <main class="md:container flex mx-auto pt-5">
                <base-sidebar />
                <div class="flex-auto ps-8" v-if="!isLoading">
                    <div class="relative">
                        <ProfileBanner />
                        <ProfileAvatar />
                    </div>
                    <div class="info pt-6 flex pb-8 border-solid border-b-2 border-pink-700">
                        <div class="pl-48 text-white text-lg">{{login}}</div>
                        <ProfileFollowers />
                    </div>
                    <ProfileFeed />
                </div>
            </main>
        </div>



</template>

<script setup>

import BaseHeader from "../Header/Header.vue";
import {computed} from "vue";
import types from "../../../store/posts/types.js";
import profileTypes from "../../../store/profile/types.js";
import FavoriteIcon from '../Pages/icons/favorite.svg?component';



import { useRoute } from 'vue-router'

import BaseSidebar from "../common/BaseSidebar.vue";
import ProfileAvatar from "./components/ProfileAvatar.vue";
import ProfileBanner from "./components/ProfileBanner.vue";
import store from "../../../store/store.js";
import ProfileFollowers from "./components/ProfileFollowers.vue";
import ProfileFeed from "./components/ProfileFeed.vue";



const isLoading = computed(() => store.state.profile.isLoading)
const login = computed(() => store.state.profile.user.name)

const route = useRoute()
const slug = route.params.slug


if (!store.state.profile.user.name) {
    store.dispatch('profile/' + profileTypes.UPLOAD_USER, {slug})

}
</script>

<style lang="scss">
.pulse-item {
    pointer-events: none;
    position: absolute;
    border: 2px solid #DB2777;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;

    animation: pulse 1s linear infinite;
    transition: all 0.3s ease 0s;
}
.pulse-item {

}
.pulse::before,
.pulse::after {
    content: '';
    position: absolute;
    border: 2px solid #DB2777;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    pointer-events: none;

    transition: all 0.3s ease 0s;
}
.pulse::before {
    animation: pulse2 1.2s linear infinite;
}
.pulse::after {
    animation: pulse3 1.4s linear infinite;
}


@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: scale(1.14);
        opacity: 0;
    }
}

@keyframes pulse2 {
    0% {
        transform: scale(1);
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: scale(1.18);
        opacity: 0;
    }
}
@keyframes pulse3 {
    0% {
        transform: scale(1);
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: scale(1.22);
        opacity: 0;
    }
}
body {
    @apply text-white;
}
*::selection {
    @apply text-white bg-pink-700;
}
.icon svg {
    width: 28px;
    height: 28px;
    fill: #fff !important;
}
</style>

